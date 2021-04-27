<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\Email;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * register a new user and email the user to confirm.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request) {
        try {
            $input = $request->only(['email', 'password']);
            $first_name = $request->input('first_name');
            $last_name = $request->input('last_name');
            $country = $request->input('country');
            $email = $input['email'];
            $password_input = $input['password'];
            $password = Hash::make($password_input);
            $users = User::where(['email' => $email])->get();
            $token = Hash::make($email);
            // registered
            if (count($users)== 0) {
                $user = new User();
                $user->email = $email;
                $user->first_name = $first_name;
                $user->last_name = $last_name;
                $user->password = $password;
                $user->country = $country;
                $user->token = $token;
                $user->save();
            } else {
                return response()->json([
                    'code' => BAD_REQUEST_CODE,
                    'message' => ALREADY_EXIST_MESSAGE
                ]);
            }

            Mail::to($email)->send(
                new Email('register-email', 'Aktywacja konta', ['url' => env('REGISTER_VERIFICATION_URL').$token])
            );
            return response()->json([
                'code' => SUCCESS_CODE,
                'message' => REGISTER_SUCCEED_MESSAGE
            ]);
        } catch (Exception $e) {
            User::where(['email' => $email])->delete();
            return response()->json([
                'code' => SERVER_ERROR_CODE,
                'message' => FAILED_SEND_MESSAGE
            ]);
        }
    }

    /**
     * login wtih the email and password.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request) {
        try {
            $input = $request->only(['email', 'password']);
            $email = $input['email'];
            $password_input = $input['password'];
            $is_social = $request->input('is_social');

            $users = User::where(['email' => $email])->get();
            if ($is_social === true) {
                $password = Hash::make('123456');
                if (count($users) === 0) {
                    $user = new User();
                    $user->email = $email;
                    $user->password = $password;
                    $user->first_name = $request->input('first_name');
                    $user->last_name = $request->input('last_name');
                    $user->is_valid = true;
                    $user->save();
                }
                $input['password'] = '123456';
                $token = Auth::attempt($input);
                return response()->json([
                    'code' => SUCCESS_CODE,
                    'message' => LOGIN_SUCCEED_MESSAGE,
                    'data' => ['token' =>  $token]
                ]);
            }
            else
            {
                if (count($users) == 0) {
                    return response()->json([
                        'code' => BAD_REQUEST_CODE,
                        'message' => NOT_EXIST_MESSAGE
                    ]);
                } else if ($users[0]->is_valid == false) {
                    return response()->json([
                        'code' => BAD_REQUEST_CODE,
                        'message' => NOT_CONFIRMED_MESSAGE
                    ]);
                } else if ($users[0]->status == false || $users[0]->activate_status == false) {
                    return response()->json([
                        'code' => BAD_REQUEST_CODE,
                        'message' => NOT_CONFIRMED_MESSAGE
                    ]);
                } else {
                    if (Hash::check($password_input, $users[0]->password)) {
                        $token = Auth::attempt($input);
                        return response()->json([
                            'code' => SUCCESS_CODE,
                            'message' => LOGIN_SUCCEED_MESSAGE,
                            'data' => ['token' =>  $token]
                        ]);
                    } else {
                        return response()->json([
                            'code' => BAD_REQUEST_CODE,
                            'message' => NOT_EXIST_MESSAGE
                        ]);
                    }
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'code' => SERVER_ERROR_CODE,
                'message' => SERVER_ERROR_MESSAGE
            ]);
        }

    }

    /**
     * reset password wtih the email.
     *
     * @param  Request  $request
     * @return Response
     */
    public function forgot(Request $request) {
        try {
            $input = $request->only(['email']);
            $email = $input['email'];
            $users = User::where(['email' => $email])->get();

            if (count($users) == 0) {
                return response()->json([
                    'code' => BAD_REQUEST_CODE,
                    'message' => NOT_EXIST_ACCOUNT_MESSAGE
                ]);
            } else {
                $token = mt_rand(100000, 999999);
                User::where(['email' => $email])->update(['token' => $token]);
                Mail::to($email)->send(
                    new Email('forgotpassword-email', 'Forgot Password', ['digits' => $token])
                );
                return response()->json([
                    'code' => SUCCESS_CODE,
                    'message' => FORGOTPASSWORD_SUCCEED_MESSAGE
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'code' => SERVER_ERROR_CODE,
                'message' => SERVER_ERROR_MESSAGE
            ]);
        }

    }

    /**
     * reset password wtih the email.
     *
     * @param  Request  $request
     * @return Response
     */
    public function verify_confirmation(Request $request) {
        try {
            $input = $request->only(['digits', 'email']);
            $digits = $input['digits'];
            $email = $input['email'];
            $users = User::where(['email' => $email, 'token' => $digits])->get();

            if (count($users) == 0) {
                return response()->json([
                    'code' => BAD_REQUEST_CODE,
                    'message' => NOT_EXIST_ACCOUNT_MESSAGE
                ]);
            } else {
                return response()->json([
                    'code' => SUCCESS_CODE,
                    'message' => CONFIRM_CODE_SUCCESS_MESSAGE
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'code' => SERVER_ERROR_CODE,
                'message' => SERVER_ERROR_MESSAGE
            ]);
        }

    }

}
