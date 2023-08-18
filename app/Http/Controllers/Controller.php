<?php

namespace App\Http\Controllers;
use Cloudinary\Cloudinary as Cloudinary;
use App\Models\Employee;
use App\Models\Client;
use App\Models\Documents;
use App\Models\User;
use App\Models\Packages;
use App\Models\Property;
use App\Models\UserProperty;
use App\Models\Transactions;
use App\Models\Support;
use App\Models\Payment;
use App\Models\Admin;
use Maatwebsite\Excel\Facades\Excel as Excel;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Imports\ImportUser;
use Illuminate\Support\Facades\Hash;
use Mail;
use Exception;
use App\Mail\forgetPwd;
use App\Mail\contactForm;
use Illuminate\Support\Facades\Mail as FacadesMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    

    // Admin Functions
    public function adminLogin(Request $request){
      $is_admin = session()->get('package_id');
      if(!isset($is_admin) || !$is_admin)
        return view('admin.auth.login');
      else{
        return redirect()->route('adminDashboard');
      }
    }

    public function adminLoginPost(Request $request){
        $request->validate([
          'email' => 'required|string',
          'password' => 'required|string'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::guard('admin')->attempt($credentials))
          return response()->json([
            'message' => 'Unauthorized',
            'type'=>'failed'
          ], 401);
          
        $request->session()->put('user_type', 'admin');
        return response()->json([
          'message'=>'welcome',
          'type'=>'success'
        ]);
    }

    public function adminDashboard(Request $request){
      $this->checkUserType($request);
      $data['usercount'] = User::all()->count();
      $data['packagecount'] = Packages::all()->count();
      $data['paymentcount'] = Payment::sum("amount");
      $data['users'] = User::select('*')->with('package')->orderBy('id', 'desc')->limit(10)->get()->toArray();
      $data['ticket'] = Support::select('*')->with('user')->orderBy('id', 'desc')->get()->toArray();

      // dd($data['ticket']);
      return view('admin.dashboard', $data);
    }

    public function checkUserType(Request $request){
      // Check User Type and Redirect
      if($request->session()->has('user_type') && $request->session()->get('user_type') != 'admin')
        return redirect()->route('userLogin');
    }

    public function allSupport(){
      $data['ticket'] = Support::select('*')->with('user')->orderBy('id', 'desc')->get()->toArray();

      // dd($data['ticket']);
      return view('admin.support', $data);
    }

    public function myAccount(){
      $data['data']=Auth::guard('admin')->user();
      return view('admin.account', $data);
    }

    public function updateAccount(Request $request){
      $user=$request->validate([
        'username' => 'required|string',
        'email' => 'required|string|email',
        'mobile' => 'required|string',
        'address' => 'required|string',
        'website' => 'required|string',
      ]);
      
      if ($request->logo){
        $request->validate([
          'logo' => 'required|mimes:jpeg,PNG,JPEG,png,jpg|max:2048',
        ]);

        $fileName = time().'_'.$request->file('logo')->getClientOriginalName(); 
        $filePath = 'logo/'.$fileName;

        Storage::putFileAs('logo', $request->file('logo'), $fileName, 'public');
        Storage::url($fileName);
        $user['logo'] = $filePath;

      }
       
      $user['website'] = strpos($request->website, 'http') !== false || strpos($request->website, 'https') !== false ? $request->website : 'https://'.$request->website;
      $update = Admin::where('id',Auth::guard('admin')->user()->id)->update($user);

      if($update){
        return response()->json([
          'message'=>'Profile Updated',
          'type'=>'success'
        ]);  
      }else{
        return response()->json([
          'message' => 'Opps! Operation failed',
          'type'=>'failed'
        ], 401);
      }
    }

    public function supportReply(Request $request){
      if($request->session()->has('user_type') && $request->session()->get('user_type') != 'admin')
        return response()->json(['message' => 'Invalid Request','type'=>'failed'], 401);

        
      $data = $request->validate([
        'id' => 'required',
        'reply' => 'required'
      ]);
      
      $update = Support::where(['id' => $data['id']])->update(['reply' => $data['reply']]);
      if($update){
        return response()->json([
          'message'=>'Support Ticket Updated',
          'type'=>'success'
        ]);  
      }else{
        return response()->json([
          'message' => 'Opps! Operation failed',
          'type'=>'failed'
        ], 401);
      }
    }

    public function allUsers(Request $request){
        $this->checkUserType($request);
        $data['users'] = User::select('*')->with('property')->get()->toArray();
        $data['property'] = Property::where('status',1)->get()->toArray();
        return view('admin.manageUser',$data);
    }

    public function settings(Request $request){
      $params=$request->validate([
        'new_pwd' => 'required|string',
        'confirm_pwd' => 'required|string|same:new_pwd'
      ]);
      $update=Admin::where('id',Auth::guard('admin')->user()->id)->update(['password'=>hash::make($params['new_pwd'])]);
      if($update){
        return response()->json([
          'message'=>'Password Updated',
          'type'=>'success'
        ]);  
      }else{
        return response()->json([
          'message' => 'Opps! Operation failed',
          'type'=>'failed'
        ], 401);
      }
    }

    public function addUser(Request $request){
      
        $process = $request->input('process');
        if($process == 'add'){
          $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|numeric|unique:users,mobile',
            'dcrypt_password' => 'required',
          ],[
            'email.unique' => 'Email ID Already exists',
            'mobile.unique' => 'Mobile Number Already exists',
          ]);
          
          if(isset($request['property']) && !empty($request['property'])){

            $propertyData = $request->validate([
              'property.*.property_id' => 'required',
              'property.*.emi_amount' => 'required|numeric',
              'property.*.first_emi_date' => 'required|date',
              'property.*.emi_count' => 'required|numeric',
            ],[
              'property.*.property_id.required' => 'Property Name is required!',
              'property.*.emi_amount.required' => 'Emi Amount is Required',
              'property.*.first_emi_date.required' => '1st Emi Date is Required',
              'property.*.emi_amount.numeric' => 'Emi Amount Should be Numeric',
              'property.*.emi_count.required' => 'Emi Count is Required',
              'property.*.emi_count.numeric' => 'Emi Count Should be Numeric',
            ]);
          }
        }else if($process == 'update'){
          $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$request['id'],
            'mobile' => 'required|numeric|unique:users,mobile,'.$request['id'],
            'dcrypt_password' => 'required',
          ],[
            'email.unique' => 'Email ID Already exists',
            'mobile.unique' => 'Mobile Number Already exists',
          ]);
        }

        $data['password'] = bcrypt($data['dcrypt_password']);

        if($process == 'add'){
          
          $user = new User($data);
          if($user->save()){
            if(isset($propertyData['property']) && count($propertyData['property']) > 0){
              foreach($propertyData['property'] as $key => $singleProperty){
                $singleProperty['user_id'] = $user->id;
                $singleProperty['status'] = 1;
                $singleProperty['map_id'] = uniqid();
                $userProperty = new UserProperty($singleProperty);
                $userProperty->save();
                $this->addEmiPayments($singleProperty['map_id'],$user->id,$singleProperty['property_id'],$singleProperty['emi_count'],$singleProperty['emi_amount'],$singleProperty['first_emi_date']);
              }
            }
            return response()->json(['message'=>'User Added','type'=>'success']);
          }else{
            return response()->json(['message' => 'Opps! operation failed','type'=>'failed'], 401);
          }

        }else if($process == 'update'){
          $user = User::where(['id' => $request['id']])->update($data);
          if($user)
            return response()->json(['message'=>'User Updated','type'=>'success']);
          else
            return response()->json(['message' => 'Opps! operation failed','type'=>'failed'], 401);
        }else
          return response()->json(['message' => 'Opps! operation failed','type'=>'failed'], 401);

        

    }

    public function addUserProperty(Request $request){
      if(isset($request['property']) && count($request['property']) > 0){
        foreach($request['property'] as $key => $singleProperty){
          $singleProperty['user_id'] = $request['user_id'];
          $singleProperty['status'] = 1;
          $singleProperty['map_id'] = uniqid();
          $userProperty = new UserProperty($singleProperty);
          $userProperty->save();
          $this->addEmiPayments($singleProperty['map_id'],$request['user_id'],$singleProperty['property_id'],$singleProperty['emi_count'],$singleProperty['emi_amount'],$singleProperty['first_emi_date']);
        }

        $html = $this->getPropertyTableTd($request['user_id']);
        return response()->json(['data' => $html,'message'=>'User Properties Added','type'=>'success'], 200);
      }
      else
        return response()->json(['message' => 'Opps! operation failed','type'=>'failed'], 401);
    }

    public function addUserPackage(Request $request){

        $data = $request->validate([
          'key' => 'required',
          'package_id' => 'required'
        ]);
        $package_data = Packages::select('id','package_name','client_limit','storage_limit','duration','duration_type','amount')->where('id', $data['package_id'])->first();
        if(!empty($package_data)){

          // dd($package_data);
          $today_date = date('Y-m-d');
          $duration_type = [
            'days',
            'months',
            'year',
          ];
          
          $userdata['client_limit'] = $package_data['client_limit'];
          $userdata['storage_limit'] = $package_data['storage_limit'];
          $userdata['expiry_date'] = date('Y-m-d', strtotime($today_date.' +'.$package_data['duration'].' '.$duration_type[$package_data['duration_type']]));
          
          $user = User::where(['key' => $data['key']])->update($userdata);
          $transactionData['user_id'] = $data['key'];
          $transactionData['package_id'] = $data['package_id'];
          $transactionData['amount'] = $package_data['amount'];
          $transaction = new Transactions($transactionData);
          $transactionRecord = $transaction->save();

          if($user && $transactionRecord)
            return response()->json(['message'=>'User Package '.($request['process'] == 'add' ? 'Added' : 'Updated'),'type'=>'success']);
          else
            return response()->json(['message' => 'Opps! operation failed','type'=>'failed'], 401);
        }
        else
          return response()->json(['message' => 'Invalid Package Selected','type'=>'failed'], 401);

        
    }

    public function addUpdateUserPackage($key,$package_id){

        $data = [
          'key' => $key,
          'package_id' => $package_id
        ];

        $package_data = Packages::select('id','package_name','client_limit','storage_limit','duration','duration_type','amount')->where('id', $data['package_id'])->first();
        if(!empty($package_data)){

          // dd($package_data);
          $today_date = date('Y-m-d');
          $duration_type = [
            'days',
            'months',
            'year',
          ];
          
          $userdata['client_limit'] = $package_data['client_limit'];
          $userdata['storage_limit'] = $package_data['storage_limit'];
          $userdata['expiry_date'] = date('Y-m-d', strtotime($today_date.' +'.$package_data['duration'].' '.$duration_type[$package_data['duration_type']]));
          
          $user = User::where(['key' => $data['key']])->update($userdata);
          $transactionData['user_id'] = $data['key'];
          $transactionData['package_id'] = $data['package_id'];
          $transactionData['amount'] = $package_data['amount'];
          $transaction = new Transactions($transactionData);
          $transactionRecord = $transaction->save(); 

          if($user && $transactionRecord)
            return true;
          else
            return false;
        }
        else
          return response()->json(['message' => 'Invalid Package Selected','type'=>'failed'], 401);
    }

    public function allPackages(Request $request){
      $this->checkUserType($request);
      $data['packages'] = Packages::all();
      return view('admin.managePackages',$data);
    }

    public function allProperties(Request $request){
      $this->checkUserType($request);
      $data['property'] = Property::all();
      return view('admin.manageProperties',$data);
    }

    public function getUserProperties(Request $request){
      $html = $this->getPropertyTableTd($request['user_id']);
      if($html){
        return response()->json([
          'data'=>$html,
          'type'=>'success'
        ]);  
      }else{
        return response()->json([
          'data' => '',
          'type'=>'failed'
        ], 401);
      }
    }

    public function closeUserProperty(Request $request){

      $whereData = $request->validate([
        'user_id' => 'required|numeric',
        'map_id' => 'required'
        ]
      );

      $closeEMI = userProperty::where($whereData)->update(['status' => 0]);

      $html = $this->getPropertyTableTd($request['user_id']);
      if($closeEMI){
        return response()->json([
          'data'=>$html,
          'message' => 'Emi Closed Successfully!!',
          'type'=>'success'
        ]);  
      }else{
        return response()->json([
          'data' => '',
          'type'=>'failed'
        ], 401);
      }
    }

    public function getPropertyTableTd($user_id = 0){
      $html = '';
      if($user_id != 0){
        $property = optional(userProperty::where('user_id',$user_id)->with('property')->orderBy('id','desc')->get())->toArray();
        if(count($property) > 0){
          foreach($property as $singleProperty){
            $html .= '<tr>
                <td><a href='.('userPropertyPayment/'.$singleProperty['user_id'].'/'.$singleProperty['map_id']).'>'.$singleProperty['property']['property_name'].'</a></td>
                <td>'.$singleProperty['emi_amount'].'</td>
                <td>'.$singleProperty['emi_count'].'</td>
                <td>'.($singleProperty['status'] == 0 ? '<span class="badge bg-danger">Closed</span>' : '<span class="badge bg-success">Open</span>').'</td><td>';
                
            if($singleProperty['status'] == 1){
                $html .= '<button type="button" onclick=closeEMI(this) class="btn btn-danger btn-sm" data-map_id='.$singleProperty['map_id'].' data-user_id='.$singleProperty['user_id'].'>Close EMI</button>';
            }
            $html .= '</td></tr>';
          }
        }
      }

      return $html;
    }

    public function addEmiPayments($map_id,$user_id,$property_id,$emi_count,$emi_amount,$first_emi_date){
      for($i=0;$i<= $emi_count;$i++){
        $emi_date = $i == 0 ? Carbon::parse($first_emi_date) : Carbon::parse($first_emi_date)->addMonth($i);
        $data['user_id'] = $user_id;
        $data['property_id'] = $property_id;
        $data['emi_count'] = $i+1;
        $data['emi_amount'] = $emi_amount;
        $data['due_date'] = $emi_date;
        $data['map_id'] = $map_id;
        $data['status'] = 0;
        $data['updated_by'] = 1;

        $Payment = new Payment($data);
        $Payment->save();
      }
    }

    public function getPropertyOptions(){
      $property = optional(Property::where('status',1)->get())->toArray();
      $html = '';
      if(count($property) > 0){
          foreach($property as $singleProperty){
            $html .= '<option value='.$singleProperty['id'].'>'.$singleProperty['property_name'].'</option>';
          }
      }
      if($html){
        return response()->json([
          'data'=>$html,
          'type'=>'success'
        ]);  
      }else{
        return response()->json([
          'data' => '',
          'type'=>'failed'
        ], 401);
      }
    }

    public function addProperty(Request $request){

      if($request->session()->has('user_type') && $request->session()->get('user_type') != 'admin')
        return response()->json(['message' => 'Invalid Request','type'=>'failed'], 401);

      $propertyData = $request->validate([
        'property_name' => 'required|string',
        'address' => 'required|string',
        'description' => 'required|string',
      ]);

      $propertyData['description'] = addslashes($propertyData['description']);
      $process = $request->input('process');

      if($process == 'add'){
        $property = new Property($propertyData);
        $property->save();
        $property_id = $property->id;
        
      }else if($process == 'update'){
        $property_id = $request->id;
        $property = Property::where(['id' => $property_id])->update($propertyData);
      }
      
      // Add Documents
      if ($request->documents){
          foreach($request->documents as $key=>$file) {
            $request->validate([
                'documents.'.$key.'.name' => 'required',
                'documents.'.$key.'.file' => 'required|mimes:doc,docx,xlsx,xls,pdf,zip,png,bmp,jpg,mp4|max:100000',
            ],[
              'documents.*.name.required' => 'Please Enter File name',
              'documents.*.file.required' => 'Please select File',
              'documents.*.file.mimes' => 'Only doc,docx,xlsx,xls,pdf,zip,png,bmp,jpg Type Accepted',
              'documents.*.file.max' => 'File size cannot be Greater 5mb',
            ]);
            
            $fileName = time().'_'.$file['name'].'_'.$file['file']->getClientOriginalName(); 
            $filePath = 'documents/'.str_replace(' ','_',$propertyData['property_name']).'/'.$fileName;

            Storage::putFileAs('documents/'.str_replace(' ','_',$propertyData['property_name']), $file['file'], $fileName, 'public');
            Storage::url($fileName);
                            
            // Create files
            $documentData = [
              'property_id' => $property_id,
              'document_name' => $file['name'],
              'document_url' => $filePath
            ];
            Documents::create($documentData);
        }
      }
      

      if($property)
        return response()->json(['message'=>'Package '.($process == 'add' ? 'Added' : 'Updated'),'type'=>'success']);
      else
        return response()->json(['message' => 'Opps! operation failed','type'=>'failed'], 401);
    }

    public function deleteProperty(Request $request){
      if($request->session()->has('user_type') && $request->session()->get('user_type') != 'admin')
        return response()->json(['message' => 'Invalid Request','type'=>'failed'], 401);

        
      $data = $request->validate([
        'id' => 'required'
      ]);
      
      $delete = Property::where(['id' => $data['id']])->delete();
      $deleteDoc = optional(Documents::where(['property_id' => $data['id']])->delete());
      if($delete && $deleteDoc){
        return response()->json([
          'message'=>'Property Deleted',
          'type'=>'success'
        ]);  
      }else{
        return response()->json([
          'message' => 'Opps! Operation failed',
          'type'=>'failed'
        ], 401);
      }
    }

    public function deleteUser(Request $request){
      if($request->session()->has('user_type') && $request->session()->get('user_type') != 'admin')
        return response()->json(['message' => 'Invalid Request','type'=>'failed'], 401);

        
      $data = $request->validate([
        'id' => 'required'
      ]);
      
      $delete = User::where(['id' => $data['id']])->delete();
      if($delete){
        return response()->json([
          'message'=>'User Deleted',
          'type'=>'success'
        ]);  
      }else{
        return response()->json([
          'message' => 'Opps! Operation failed',
          'type'=>'failed'
        ], 401);
      }
    }

    public function updateUserStatus(Request $request){
      if($request->session()->has('user_type') && $request->session()->get('user_type') != 'admin')
        return response()->json(['message' => 'Invalid Request','type'=>'failed'], 401);

        
      $data = $request->validate([
        'id' => 'required',
        'value' => 'required'
      ]);
      
      $update = User::where(['id' => $data['id']])->update(['status' => $data['value']]);
      if($update){
        return response()->json([
          'message'=>'User Updated',
          'type'=>'success'
        ]);  
      }else{
        return response()->json([
          'message' => 'Opps! Operation failed',
          'type'=>'failed'
        ], 401);
      }
    }

    public function addUserPayment(Request $request){

      $data = $request->validate([
        'key' => 'required',
        'package_id' => 'required'
      ]);
      
      $package_data = Packages::select('id','amount')->where('id', $data['package_id'])->first();
      if(!empty($package_data)){
        $PaymentData['user_id'] = $data['key'];
        $PaymentData['package_id'] = $data['package_id'];
        $PaymentData['amount'] = $package_data['amount'];
        $PaymentData['payment_date'] = $request['payment_date'];
        $Payment = new Payment($PaymentData);
        $PaymentRecord = $Payment->save();
        if($PaymentRecord)
          return response()->json(['message'=>'User Payment Added','type'=>'success']);
        else
          return response()->json(['message' => 'Opps! operation failed','type'=>'failed'], 401);
      }
      else
        return response()->json(['message' => 'Invalid Package Selected','type'=>'failed'], 401);
    }

    public function adminLogout(){
      Auth::logout();
      return redirect()->route('adminLogin');
    }

    public function userPropertyPayment(Request $request,$user_id = 0,$map_id = 0){
      $this->checkUserType($request);
      $data['payments'] = optional(Payment::where(['user_id' => $user_id,'map_id' => $map_id])->with('property')->get())->toArray();
      return view('admin.manageUserPayments',$data);
    }

    public function updateUserPaymentDetails(Request $request){
      $data = $request->validate([
        'id' => 'required',
        'user_id' => 'required',
        'status' => 'required'
      ]);


      $updateData['status'] = $request['status'] == 'on' ? 1 : 0;
      $updateData['transaction_id'] = $request['transaction_id'];
      $updateData['remark'] = $request['remark'];
      $response = Payment::where(['user_id' => $data['user_id'],'id' => $data['id']])->update($updateData);
      if($response){
        return response()->json([
          'message'=>'User Payment Updated',
          'type'=>'success'
        ]);  
      }else{
        return response()->json([
          'message' => 'Opps! Operation failed',
          'type'=>'failed'
        ], 401);
      }
    }
    // User Functions-------------------------------------------------------
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|',
            'c_password'=>'required|same:password',
            'mobile' => 'required|string',
          ]);
      
          $user = new User([
            'name' => $request->name,
            'password' =>  bcrypt($request->password),
            'email' => $request->email,
            'mobile' => $request->mobile,
            'username' => $request->username,
            'register_ip' => '168.192.1.92', // need to make it dynamic
            'status' => 1,
          ]);
          if($user->save()){
            return redirect('/dev');
          }else{
            return response()->json(['error'=>'Provide proper details']);
          }
    }
    
    public function login(Request $request){
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
          ]);
          $request['status'] = 1;
          $credentials = request(['email', 'password', 'status']);
          if(!Auth::attempt($credentials))
            return response()->json([
              'message' => 'Unauthorized',
              'type'=>'failed'
            ], 401);

          $path = storage_path('app/documents/'.Auth::user()->key);
          if(!File::isDirectory($path))
              File::makeDirectory($path, 0777, true, true);

          return response()->json([
            'message'=>'welcome',
            'type'=>'success'
          ]);
    }

    public function logout(){
      Auth::logout();
      return redirect()->route('login');
    }
    
    public function dashboard(){
        $usercount = Client::all();
        $data['usercount'] = count($usercount);

        $data['details'] = User::select('*')->where('id',Auth::user()->id )->with('package')->get();
        $expiry_date = Carbon::parse(Auth::user()->expiry_date);
        $today = Carbon::parse(date('Y-m-d')); 
        $days = $expiry_date->diffInDays($today);

        if($days <= 30){
            $data['expiry_notice'] = 'Hello, '.ucwords(Auth::user()->name).' Your Subscription has '.$days.' Days Left';
        }
        
        return view('index',$data);
    }

    public function addClient(Request $request){
      

      $userData = User::select('client_limit','expiry_date','client_created','storage_limit','storage_used')->where('id',Auth::user()->id)->first()->toArray();
      
      $today = Carbon::createFromFormat('m/d/Y H:i:s', date('d/m/Y H:i:s'));
      $expiryDate = Carbon::createFromFormat('m/d/Y H:i:s', date('d/m/Y H:i:s',strtotime($userData['expiry_date'])));

      if($today->gte($expiryDate))
        return response()->json(['message' => 'Opps! You Package is Expired, cannot create client, contact Admin to upgrade your package!','type'=>'failed'], 401);

      if(($userData['client_limit'] == $userData['client_created']) || ($userData['storage_limit'] == $userData['storage_used']))
        return response()->json(['message' => 'Opps! You Package Limit reached cannot create client, contact Admin to upgrade your package!','type'=>'failed'], 401);


      $client = $request->validate([
        'company_name' => 'required|string',
        'machine_name' => 'required|string',
        'serial_number' => 'required|string',
        'machine_details' => 'required|string',
        'valid_till' => 'required|string',
      ]);

      $process = $request->input('process');

      if($process == 'add'){
        $client['user_id'] = Auth::user()->key;
      
      $user = new Client($client);

        // Add Documents
        
        if (!empty($request->documents[0]['name']) && isset($request->documents[0]['file'])){

            $goAhead = false;
            $storage_limit = $userData['storage_limit'];
            $storage_used = $userData['storage_used'];
            $storage_left = $userData['storage_limit'] - $userData['storage_used'];
            $file_size = 0;
            foreach($request->documents as $key=>$file) {
                $file_size += $file['file']->getSize();
            }

            // Check storage size alloted and used and compare left storage with current upload
            $size_mb = round($file_size/1048576, 2);
            if($size_mb > $storage_left)
              return response()->json(['message' => 'Opps! You Package Limits reached cannot create client, contact Admin to upgrade your package!','type'=>'failed'], 401);
            else
              $goAhead = true;

            // After validation proceed to upload documents
            if($goAhead){
              foreach($request->documents as $key=>$file) {

                  $request->validate([
                      'documents.'.$key.'.name' => 'required',
                      'documents.'.$key.'.file' => 'required|mimes:doc,docx,xlsx,xls,pdf,zip,png,bmp,jpg,mp4|max:50000',
                  ],[
                    'documents.*.name.required' => 'Please Enter File name',
                    'documents.*.file.required' => 'Please select File',
                    'documents.*.file.mimes' => 'Only doc,docx,xlsx,xls,pdf,zip,png,bmp,jpg Type Accepted',
                    'documents.*.file.max' => 'File size cannot be Greater 2mb',
                  ]);
                  
                  $fileName = time().'_'.$file['name'].'_'.$file['file']->getClientOriginalName(); 
                  $filePath = 'documents/'.Auth::user()->key.'/'.$fileName;

                  Storage::putFileAs('documents/'.Auth::user()->key, $file['file'], $fileName, 'public');
                  Storage::url($fileName);
                                  
                  // Create files
                  $documentData = [
                    'user_id' => $client['user_id'],
                    'document_name' => $file['name'],
                    'document_url' => $filePath
                  ];

                  Documents::create($documentData);
              }
            }
        }
      }
      else if($process == 'update'){
        $data = $request->validate([
          'user_id' => 'required|string'
        ]);
        
        $user = Client::where('user_id',$data['user_id'])->update($client);
        
        // Add Documents
        if ($request->documents){

            $goAhead = false;
            $storage_limit = $userData['storage_limit'];
            $storage_used = $userData['storage_used'];
            $storage_left = $userData['storage_limit'] - $userData['storage_used'];
            $file_size = 0;
            foreach($request->documents as $key=>$file) {
                $file_size += $file['file']->getSize();
            }

            // Check storage size alloted and used and compare left storage with current upload
            $size_mb = round($file_size/1048576, 2);
            if($size_mb > $storage_left)
              return response()->json(['message' => 'Opps! You Package Limits reached cannot create client, contact Admin to upgrade your package!','type'=>'failed'], 401);
            else
              $goAhead = true;

            // After validation proceed to upload documents
            if($goAhead){

              foreach($request->documents as $key=>$file) {

                  if(isset($file['file']) && $file['file'] !=null){
                    $request->validate([
                        'documents.*.name' => 'required',
                        'documents.*.file' => 'required|mimes:doc,docx,xlsx,xls,pdf,zip,png,bmp,jpg|max:2048',
                    ],[
                      'documents.*.name.required' => 'Please Enter File name',
                      'documents.*.file.required' => 'Please select File',
                      'documents.*.file.mimes' => 'Only doc,docx,xlsx,xls,pdf,zip,png,bmp,jpg Type Accepted',
                      'documents.*.file.max' => 'File size cannot be Greater 2mb',
                    ]);
                    
                    $fileName = time().'_'.$file['name'].'_'.$file['file']->getClientOriginalName(); 
                    $filePath = 'documents/'.Auth::user()->key.'/'.$fileName;

                    Storage::putFileAs('documents/'.Auth::user()->key, $file['file'], $fileName, 'public');
                    Storage::url($fileName);
                                    
                    // // Create files
                    $documentData = [
                      'user_id' => $data['user_id'],
                      'document_name' => $file['name'],
                      'document_url' => $filePath
                    ];

                    Documents::create($documentData);
                }
              }
            }
        }
      
      }

      if($process == 'add' ? $user->save() : $user){
        $userData['storage_used'] = $userData['storage_used'] + round($file_size/1048576, 2);
        if($process == 'add'){
          $userData['client_created'] = $userData['client_created'] + 1;
        }
        User::where('id', Auth::user()->id)->update($userData);
        return response()->json(['message'=>'Client '.($process == 'add' ? 'Added' : 'Updated'),'type'=>'success']);
        
      }
      else
        return response()->json(['message' => 'Opps! operation failed','type'=>'failed'], 401);

    }

    public function allClient(){
      $clients= Client::where('user_id',Auth::user()->key)->orderBy('id','desc')->get();
      return view('all-clients', ['clients' => $clients]);
    }

    public function clientDetails($user_id = 0){

      if($user_id == 0)
      return response()->json([
        'message' => 'Invalid Access',
        'type'=>'failed'
      ], 401);


      $data['admin_data'] = User::where('id', 1)->first()->toArray();
      $date = today()->format('Y-m-d');
      $data['client_data'] = Client::select('*')->where('user_id',$user_id)->first()->toArray();
      $data['documents'] = Documents::select('*')->where('user_id',$user_id)->get()->toArray();

     if($data['client_data']['valid_till'] < $date)
        return response()->json([
          'message'=>'Validity Date Expired!!',
          'type'=>'error'
        ]);
     else
        return view('clients-details', ['data' => $data]);
    }

    public function deleteClient(Request $request){
      $data = $request->validate([
        'id' => 'required',
        'user_id' => 'required',
      ]);
      
      $delete = Client::where(['id' => $data['id'], 'user_id' => $data['user_id']])->delete();
      if($delete){
        return response()->json([
          'message'=>'Employee Deleted',
          'type'=>'success'
        ]);  
      }else{
        return response()->json([
          'message' => 'Opps! Operation failed',
          'type'=>'failed'
        ], 401);
      }
    }
    
    public function generateQRCode($user_id, $company_name){
      
      if(!$user_id || !$company_name)
        return response()->json([
          'message' => 'Invalid Access',
          'type'=>'failed'
        ], 401);
      
        $output_file = str_replace(' ','_',$company_name).'.svg';
        $fileDest = storage_path('app/Qrcode/'.$output_file);

        if(File::exists($fileDest)) 
          File::delete($fileDest);
          
        $image = \QrCode::size(300)
        ->generate(url('/clientDetails/'.$user_id), $fileDest);

        return response()->download($fileDest);
    }

    public function downloadDoc($user_id = 0,$id = 0){
      $data = Documents::where(['id' => $id, 'user_id' => $user_id])->first()->toArray();
      if($data != ''){
        $url = storage_path('app/'.$data['document_url']);
        if(!File::exists($url)) 
            return;

        return response()->download($url);
      }
      else
      return;
    }

    public function getDocument($property_id = 0){
      
      if($property_id == 0)
        return response()->json([
          'message'=>'Invalid Access',
          'html' => '',
          'type'=>'error'
        ]);

      $data = Documents::where('property_id', $property_id)->with('property')->get()->toArray();

      if(count($data) > 0 ){

        // <a href="'.url('downloadDoc/'.str_replace(' ','_',$singleData['property']['property_name']).'/'.$singleData['id']).'">
        $html = '';
        foreach($data as $singleData){
          $html .= '<div class="docCol col-md-4">
              <img src="'.storage_path('app/'.$singleData['document_url']).'" height="150px" width="150px">
              <label for="">'.$singleData['document_name'].'</label>
              <button type="button" class="btn btn-sm btn-danger" data-property_id="'.$singleData['property_id'].'"  data-id="'.$singleData['id'].'" onclick="deleteDoc(this)"><i class="menu-icon tf-icons bx bx-trash"></i></button>
          </div>';
        }

        return response()->json([
          'message'=>'Document Found!!',
          'html' => $html,
          'type'=>'success'
        ]);

      } else{
        return response()->json([
          'message'=>'No Documents Found',
          'html' => '',
          'type'=>'error'
        ]);
      }
    }

    public function deleteDocument($user_id = 0, $id = 0){
      if($user_id == 0 || $id == 0)
        return response()->json([
          'message'=>'Invalid Access',
          'html' => '',
          'type'=>'error'
        ]);
      
      $delete = Documents::where(['id' => $id, 'user_id' => $user_id])->delete();

      if($delete){
        return response()->json([
          'message'=>'Client Document Deleted',
          'type'=>'success'
        ]);  
      }else{
        return response()->json([
          'message' => 'Opps! Operation failed',
          'type'=>'failed'
        ], 401);
      }
    }

    // import excel
    public function importView(Request $request){
      return view('importFile');
    }

    public function import(Request $request){
        Excel::import(new ImportUser,
                      $request->file('file')->store('files'));
        return redirect()->back();
    }
    // excel end
    public function forgetPwdMail(Request $request)
    {
      $email=$request->validate([
        'email' => 'required|string'
      ]);
      $isExist=User::where('email',$email)->count();
      if($isExist>0){
        $pwd=rand(11111,99999);
        User::where('email',$email)->update(['dcrypt_password' => $pwd,'password'=>hash::make($pwd)]);
        Mail::to($email)->send(new forgetPwd($pwd));
        return response()->json([
          'message'=>'New password sent on your mail',
          'type'=>'success'
        ]);
      }else{
        return response()->json([
          'message' => 'Opps! no user found with this Email Id',
          'type'=>'failed'
        ], 401);
      }
    }

    public function changePwd(Request $request){
      $params=$request->validate([
        'new_pwd' => 'required|string',
        'confirm_pwd' => 'required|string|same:new_pwd'
      ]);
      $update=User::where('id',Auth::user()->id)->update(['password'=>hash::make($params['new_pwd'])]);
      if($update){
        return response()->json([
          'message'=>'Password Updated',
          'type'=>'success'
        ]);  
      }else{
        return response()->json([
          'message' => 'Opps! Operation failed',
          'type'=>'failed'
        ], 401);
      }
    }

    public function manageEmp(){
      $emp=Employee::orderBy('id','desc')->get();
      return view('manage-emp',['employees'=>$emp]);
    }
    
    public function updateProfile(Request $request){
      $user=$request->validate([
        'name' => 'required|string',
        'email' => 'required|string|email',
        'mobile' => 'required|string',
        'contact_person' => 'required|string',
        'address' => 'required|string',
        'website' => 'required|string',
      ]);
      
      if ($request->logo){
        $request->validate([
          'logo' => 'required|mimes:jpeg,PNG,JPEG,png,jpg|max:2048',
        ]);

        $fileName = time().'_'.$request->file('logo')->getClientOriginalName(); 
        $filePath = 'logo/'.$fileName;

        Storage::putFileAs('logo', $request->file('logo'), $fileName, 'public');
        Storage::url($fileName);
        $user['logo'] = $filePath;


        // $cloudinary = new Cloudinary(
        //     [
        //         'cloud' => [
        //             'cloud_name' => 'dp7qjwrsu',
        //             'api_key'    => env('CLOUD_KEY'),
        //             'api_secret' => env('CLOUD_SECRET'),
        //             'url' => ['secure' => true]
        //         ],
        //     ]
        // );
        // $data = $cloudinary->uploadApi()->upload($request->file('logo')->getRealPath());
        // $user['logo'] = $data['secure_url'];

      }
       
       $user['website'] = strpos($request->website, 'http') !== false || strpos($request->website, 'https') !== false ? $request->website : 'https://'.$request->website;
      $update = User::where('id',Auth::user()->id)->update($user);

      if($update){
        return response()->json([
          'message'=>'Profile Updated',
          'type'=>'success'
        ]);  
      }else{
        return response()->json([
          'message' => 'Opps! Operation failed',
          'type'=>'failed'
        ], 401);
      }
    }

    public function contactForm(Request $request){
        
        
      $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'mobile_number' => 'required|numeric',
        'company_number' => 'required|numeric',
        'address' => 'required|string',
        'requirements' => 'required|string',
      ]);

      $user_email = User::first()->toArray()['email'];
      if($user_email){
        $email = Mail::to($user_email)->send(new contactForm($request->name, $request->email, $request->mobile_number, $request->company_number, $request->address, $request->requirements));
        return response()->json([
          'message'=>'Your Contact Details Submitted Successfully',
          'type'=>'success'
        ]);
      }else{
        return response()->json([
          'message' => 'Opps! Something went wrong try again later',
          'type'=>'failed'
        ], 401);
      }
    }

    public function account(){
      $data=User::where('id',Auth::user()->id)->get();
      return view('account',['data'=>$data[0]]);
    }

    public function createPassword($password) {
      echo bcrypt($password);
    }
    
  }