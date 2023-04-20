<?php

namespace App\Http\Livewire;

use App\Helper\PasswordHash as HelperPasswordHash;
use App\Helper\SaveData;
use App\Notifications\ThankYouForRegistrationAdmin;
use App\Notifications\ThankYouForRegistrationUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;

class RegisterForm extends Component
{
    use WithFileUploads;

    public $currentStep = 1;

    public $username, $password, $confirm_password, $email, $confirm_email, $first_name, $last_name,
        $phone_number, $country, $street, $suburb, $state_province, $postcode, $practice_name, $suburb2,
        $state_province2, $postcode2, $birth_date, $place_of_birth, $spouse_name, $proposer_name, $seconder_name,
        $cv_file, $photograph, $letter, $letter2, $degrees_diplomas, $present_surgical_appointments,
        $publications_relevant_to_hand_surgery, $areas_of_interest, $show_my_details_in_public = 'Yes',
        $show_my_details_in_private = 'Yes', $first_name2, $last_name2, $address_1, $address_2, $city, $state,
        $postal_code, $country2, $phone, $membership_id, $allPlans, $selectedPlan, $passwordStrength = 0;

    public $vpassword = 'password';
    public $vpassword1 = 'password';


    public function mount()
    {
    }

    public function render()
    {
        $this->emit('pageChanged');
        return view('livewire.register-form');
    }

    public function selectPlan($palnId)
    {
        $this->selectedPlan = $palnId;
        $this->allPlans = DB::table('pmpro_membership_levels')->get();
    }

    public function togglePasswordVisibility()
    {
        if ($this->vpassword == 'password') {
            $this->vpassword = 'text';
        } else {
            $this->vpassword = 'password';
        }
    }

    public function togglePasswordVisibility1()
    {
        if ($this->vpassword1 == 'password') {
            $this->vpassword1 = 'text';
        } else {
            $this->vpassword1 = 'password';
        }
    }

    public function step($step)
    {
        $this->currentStep = $step;
    }

    public function firstStepSubmit()
    {
        $this->validate([
            'password' => 'required|min:8',
            'confirm_password' => 'required|min:8|same:password',
            'email' => 'required|email|unique:users,user_email',
            'confirm_email' => 'required|email|unique:users,user_email|same:email'
        ], [
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 8 characters',
            'confirm_password.required' => 'Confirm password is required',
            'confirm_password.min' => 'Confirm password must be at least 8 characters',
            'confirm_password.same' => 'Confirm password must be same as password',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'email.unique' => 'Email already exists',
            'confirm_email.required' => 'Confirm email is required',
            'confirm_email.email' => 'Confirm email must be a valid email address',
            'confirm_email.unique' => 'Confirm email already exists',
            'confirm_email.same' => 'Confirm email must be same as email'
        ]);

        $this->currentStep = 2;
    }

    public function updatedPassword($password)
    {
        $value = [];
        $zxcvbn = app(\ZxcvbnPhp\Zxcvbn::class)->passwordStrength($password);
        $this->passwordStrength = $zxcvbn['score'];
    }

    public function secondStepSubmit()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
            'country' => 'required',
            'street' => 'required',
            'suburb' => 'required',
            'state_province' => 'required',
            'postcode' => 'required'
        ]);

        $this->currentStep = 3;
    }

    public function thirdStepSubmit()
    {
        $this->validate([
            'practice_name' => 'required',
            'suburb2' => 'required',
            'state_province2' => 'required',
            'postcode2' => 'required',
            'birth_date' => 'required',
            // 'place_of_birth' => 'required',
            // 'spouse_name' => 'required'
        ], [
            'practice_name.required' => 'Practice name is required',
            'suburb2.required' => 'Suburb is required',
            'state_province2.required' => 'State/Province is required',
            'postcode2.required' => 'Postcode is required',
            'birth_date.required' => 'Birth date is required',
            // 'place_of_birth.required' => 'Place of birth is required',
            // 'spouse_name.required' => 'Spouse name is required'
        ]);
        $this->currentStep = 4;
    }

    public function fourthStepSubmit()
    {
        $this->validate([
            // 'proposer_name' => 'required',
            // 'seconder_name' => 'required',
            // 'cv_file' => 'required|mimes:pdf,doc,docx',
            // 'photograph' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'letter' => 'required|file|mimes:pdf,doc,docx,jpeg,png,jpg,gif,svg|max:2048',
            // 'letter2' => 'required|file|mimes:pdf,doc,docx,jpeg,png,jpg,gif,svg|max:2048',
            // 'degrees_diplomas' => 'required',
            // 'present_surgical_appointments' => 'required',
            // 'publications_relevant_to_hand_surgery' => 'required',
            // 'areas_of_interest' => 'required',
            'show_my_details_in_public' => 'required|in:Yes,No',
            'show_my_details_in_private' => 'required|in:Yes,No'
        ]);

        $this->currentStep = 5;
    }

    public function fifthStepSubmit()
    {
        $this->validate([
            'first_name2' => 'required',
            'last_name2' => 'required',
            'address_1' => 'required',
            'address_2' => 'required',
            'city' => 'required',
            'state' => 'required',
            'postal_code' => 'required',
            'country2' => 'required',
            'phone' => 'required'
        ], [
            'first_name2.required' => 'First name is required',
            'last_name2.required' => 'Last name is required',
            'address_1.required' => 'Address 1 is required',
            'address_2.required' => 'Address 2 is required',
            'city.required' => 'City is required',
            'state.required' => 'State is required',
            'postal_code.required' => 'Postal code is required',
            'country2.required' => 'Country is required',
            'phone.required' => 'Phone is required'
        ]);

        $this->allPlans = DB::table('pmpro_membership_levels')->get();
        $this->selectedPlan = null;

        $this->currentStep = 6;
    }

    public function submit()
    {
        $this->allPlans = DB::table('pmpro_membership_levels')->get();
        // dd($this->selectedPlan);
        if (!$this->selectedPlan > 0) {
            // add custom validation message
            $this->addError('selectedPlan', 'Please select a plan');
            return;
        }
        $password = (new HelperPasswordHash(8, true))->HashPassword($this->password);
        $user_id = DB::table('users')->insertGetId([
            'user_login' => $this->email,
            'user_pass' => $password,
            'user_nicename' => $this->first_name . ' ' . $this->last_name,
            'user_email' => $this->email,
            'user_registered' => Carbon::now(),
            'user_status' => 0,
            'display_name' => $this->first_name . ' ' . $this->last_name
        ]);

        // Save the user's meta data
        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'nickname',
            'meta_value' => $this->first_name . ' ' . $this->last_name
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'first_name',
            'meta_value' => $this->first_name
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'last_name',
            'meta_value' => $this->last_name
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'description',
            'meta_value' => ''
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'rich_editing',
            'meta_value' => 'true'
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'syntax_highlighting',
            'meta_value' => 'true'
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'comment_shortcuts',
            'meta_value' => 'false'
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'admin_color',
            'meta_value' => 'fresh'
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'use_ssl',
            'meta_value' => '0'
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'show_admin_bar_front',
            'meta_value' => 'false'
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'locale',
            'meta_value' => ''
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'capabilities',
            'meta_value' => 'a:1:{s:10:"subscriber";b:1;}'
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'session_tokens',
            'meta_value' => 'a:0:{}'
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'pmpro_CardType',
            'meta_value' => ''
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'pmpro_AccountNumber',
            'meta_value' => ''
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'pmpro_ExpirationMonth',
            'meta_value' => ''
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'pmpro_ExpirationYear',
            'meta_value' => ''
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'pmpro_bfirstname',
            'meta_value' => $this->first_name2
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'pmpro_blastname',
            'meta_value' => $this->last_name2
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'pmpro_baddress1',
            'meta_value' => $this->address_1
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'pmpro_baddress2',
            'meta_value' => $this->address_2
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'pmpro_bcity',
            'meta_value' => $this->city
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'pmpro_bstate',
            'meta_value' => $this->state
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'pmpro_bzipcode',
            'meta_value' => $this->postcode
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'pmpro_bcountry',
            'meta_value' => $this->country
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'pmpro_bphone',
            'meta_value' => $this->phone
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'pmpro_bemail',
            'meta_value' => $this->email
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'phone_number',
            'meta_value' => $this->phone
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'country',
            'meta_value' => $this->country2
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'street',
            'meta_value' => $this->street
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'suburb',
            'meta_value' => $this->city
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'state_province',
            'meta_value' => $this->state_province
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'postcode',
            'meta_value' => $this->postcode2
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'practice_name',
            'meta_value' => $this->practice_name
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'state_province1',
            'meta_value' => $this->state_province2
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'postcode1',
            'meta_value' => $this->postcode2
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'birth_date',
            'meta_value' => $this->birth_date
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'place_of_birth',
            'meta_value' => $this->place_of_birth
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'spouse_s_name',
            'meta_value' => $this->spouse_name
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'proposer_name',
            'meta_value' => $this->proposer_name
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'seconder_name',
            'meta_value' => $this->seconder_name
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'degrees_and_diplomas',
            'meta_value' => $this->degrees_diplomas
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'present_surgical_appointments',
            'meta_value' => $this->present_surgical_appointments
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'publications_relevant_to_hand_surgery',
            'meta_value' => $this->publications_relevant_to_hand_surgery
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'areas_of_interest',
            'meta_value' => $this->areas_of_interest
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'show_directory_on_this_site',
            'meta_value' => $this->show_my_details_in_public
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'show_private_directory_on_this_site',
            'meta_value' => $this->show_my_details_in_private
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'pmpro_views',
            'meta_value' => ''
        ]);

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'pw_user_status',
            'meta_value' => 'denied'
        ]);

        $planLevel = DB::table('pmpro_membership_levels')->where('id', $this->selectedPlan)->first();

        SaveData::usermeta([
            'user_id' => $user_id,
            'meta_key' => 'user_level',
            'meta_value' => $planLevel->id
        ]);

        DB::table('pmpro_memberships_users')->insert([
            'user_id' => $user_id,
            'membership_id' => $planLevel->id,
            'code_id' => '0',
            'initial_payment' => $planLevel->initial_payment,
            'billing_amount' => $planLevel->billing_amount,
            'cycle_number' => $planLevel->cycle_number,
            'cycle_period' => $planLevel->cycle_period,
            'billing_limit' => $planLevel->billing_limit,
            'trial_amount' => $planLevel->trial_amount,
            'trial_limit' => $planLevel->trial_limit,
            'status' => 'active',
            'startdate' => date('Y-m-d H:i:s'),
            'enddate' => date('Y-12-31 23:59:59'),
            'modified' => date('Y-m-d H:i:s'),
        ]);

        DB::table('pmpro_membership_orders')->insert([
            'code' => str()->ucfirst(str()->random(10)),
            'session_id' => session()->getId(),
            'user_id' => $user_id,
            'membership_id' => $this->selectedPlan,
            'paypal_token' => '',
            'billing_name' => $this->first_name . ' ' . $this->last_name,
            'billing_street' => $this->address_1,
            'billing_city' => $this->city,
            'billing_state' => $this->state_province2,
            'billing_zip' => $this->postcode2,
            'billing_country' => $this->country2,
            'billing_phone' => $this->phone_number,
            'subtotal' => $planLevel->initial_payment,
            'tax' => 0,
            'couponamount' => '',
            'checkout_id' => DB::table('pmpro_membership_orders')->max('checkout_id') + 1,
            'certificate_id' => '0',
            'certificateamount' => '',
            'total' => $planLevel->initial_payment,
            'status' => 'pending',
            'gateway' => 'stripe',
            'gateway_environment' => 'live',
            'subscription_transaction_id' => '',
            'timestamp' => date('Y-m-d H:i:s'),
            'affiliate_id' => '',
            'payment_transaction_id' => '',
            'affiliate_subid' => '',
            'notes' => '',
        ]);

        Notification::route('mail', $this->email)->notify(new ThankYouForRegistrationUser($this));
        Notification::route('mail', 'admin@log.in')->notify(new ThankYouForRegistrationAdmin($this, $planLevel));

        $this->currentStep = 7;
    }
}
