<?php

namespace App\Http\Controllers;
use App\Models\Country;
use App\Models\Language;
use App\Models\Position;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * validate Token.
     *
     * @param  Request  $request
     * @return Response
     */
    public function validateToken(Request $request) {
        $user = Auth::user();
        return response()->json([
            'code' => SUCCESS_CODE,
            'message' => SUCCESS_MESSAGE,
            'role' => (string)$user->id_role
        ]);
    }

    public function getProfile(Request $request) {
        $user = Auth::user();
        return response()->json([
            'data' => [
                'user' => $user,
            ],
            'code' => SUCCESS_CODE,
            'message' => CONFIRM_CODE_SUCCESS_MESSAGE
        ]);
    }

    public function getInfo(Request $request) {
        $countries = Country::all();
        $positions = Position::all();
        $languages = Language::all();
        $provinces = Province::all();
        return response()->json([
            'data' => [
                'countries' => $countries,
                'positions' => $positions,
                'languages' => $languages,
                'provinces' => $provinces
            ],
            'code' => SUCCESS_CODE,
            'message' => CONFIRM_CODE_SUCCESS_MESSAGE
        ]);
    }
    public function getUserProfile(Request $request) {
        $id = Auth::user()->id;

        $user = User::where('id', '=', $id)
                    ->selectRaw('first_name as firstName, 
                    last_name as lastName, 
                    avatar as uploadFile, 
                    city, 
                    post_code as postCode, 
                    phone_number as phoneNumber, 
                    business_phone as businessPhone,
                    account_type as accountType,
                    company_name as companyName,
                    company_website as companyWebsite,
                    tax_number as taxNumber,
                    company_email_address as companyEmailAddress,
                    email,
                    country as selectedCountry,
                    province as selectedProvince,
                    language as selectedLanguage,
                    position as selectedPosition')->first();

        return response()->json([
            'data' => [
                'user' => $user
            ],
            'code' => SUCCESS_CODE,
            'message' => SUCCESS_FEEDBACK_CREATE,
        ]);
    }
    public function updateProfile(Request $request) {
        $id = Auth::user()->id;
        $first_name = $request->firstName;
        $last_name = $request->lastName;
        $avatar = $request->file('uploadFile');
        $city = $request->city;
        $post_code = $request->postCode;
        $phone_number = $request->phoneNumber;
        $business_phone = $request->businessPhone;
        $account_type = $request->accountType;
        $company_name = $request->companyName;
        $company_website = $request->companyWebsite;
        $tax_number = $request->taxNumber;
        $company_email_address = $request->companyEmailAddress;
        $email = $request->email;
        $password = $request->currentPassword;
        $newPassword = $request->newPassword;

        $user = [];
        $user['first_name'] = $first_name;
        $user['last_name'] = $last_name;
        $user['city'] = $city;
        $user['post_code'] = $post_code;
        $user['phone_number'] = $phone_number;
        $user['business_phone'] = $business_phone;
        $user['account_type'] = $account_type;
        $user['company_name'] = $company_name;
        $user['company_website'] = $company_website;
        $user['tax_number'] = $tax_number;
        $user['company_email_address'] = $company_email_address;
        $user['email'] = $email;
        $destination_path = 'uploads/';
        if ($avatar) {
            $user['avatar'] = env('BACKEND_URL').$destination_path.$id;
            File::delete($destination_path.$id);
            $avatar->move($destination_path, $id);
        }

        if ($password && strlen($password) !== 0) {
            $password_input = Hash::make($newPassword);
            $user['password'] = $password_input;
        }
        User::where('id', '=' ,$id)->update($user);

        return response()->json([
            'code' => SUCCESS_CODE,
            'message' => SUCCSES_UPDATE_PROFILE,
        ]);
    }
}
