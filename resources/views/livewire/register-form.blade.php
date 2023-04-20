<form class="m-b-150">
    @if($currentStep == 1)
    <div class="col-md-4 mx-auto">
        <div id="step1">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control form-control-lg" id="email" placeholder="Enter email"
                    wire:model="email" value="{{ old('email') }}">
                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="confirm_email" class="form-label">Confirm Email address</label>
                <input type="email" class="form-control form-control-lg" id="confirm_email"
                    placeholder="Enter confirm email" wire:model="confirm_email" value="{{ old('confirm_email') }}">
                @error('confirm_email') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="{{ $vpassword }}" class="form-control form-control-lg" id="password"
                        placeholder="Enter password" wire:model="password" value="{{ old('password') }}">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2"
                        wire:click="togglePasswordVisibility">Show</button>
                </div>
                @if($password)
                <small class="text-muted">
                    <span class="text-danger" wire:loading wire:target="updatedPassword">Checking...</span>
                    <span wire:loading.remove wire:target="passwordStrength">
                        @if($passwordStrength == 0)
                        <span class="text-danger">Very Weak</span>
                        @elseif($passwordStrength == 1)
                        <span class="text-danger">Weak</span>
                        @elseif($passwordStrength == 2)
                        <span class="text-warning">Medium</span>
                        @elseif($passwordStrength == 3)
                        <span class="text-info">Strong</span>
                        @elseif($passwordStrength == 4)
                        <span class="text-success">Very Strong</span>
                        @endif
                    </span>
                </small>
                @endif
                @error('password') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <div class="input-group">
                    <input type="{{ $vpassword1 }}" class="form-control form-control-lg" id="confirm_password"
                        placeholder="Enter confirm password" wire:model="confirm_password"
                        value="{{ old('confirm_password') }}">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2"
                        wire:click="togglePasswordVisibility1">Show</button>
                </div>
                @error('confirm_password') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="d-flex justify-content-end mt-4">
                <button type="button" class="btn btn-primary" wire:click="firstStepSubmit">
                    <i class="fa fa-spinner fa-spin" wire:loading wire:target="firstStepSubmit"></i>
                    Next
                </button>
            </div>
        </div>
    </div>
    @elseif($currentStep == 2)
    <div class="col-md-4 mx-auto">
        <div id="step2">
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control form-control-lg" id="first_name" placeholder="Enter first name"
                    wire:model="first_name" value="{{ old('first_name') }}">
                @error('first_name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control form-control-lg" id="last_name" placeholder="Enter last name"
                    wire:model="last_name" value="{{ old('last_name') }}">
                @error('last_name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control form-control-lg" id="phone_number"
                    placeholder="Enter phone number" wire:model="phone_number" value="{{ old('phone_number') }}">
                @error('phone_number') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <input type="text" class="form-control form-control-lg" id="country" placeholder="Enter country"
                    wire:model="country" value="{{ old('country') }}">
                @error('country') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="street" class="form-label">Street</label>
                <input type="text" class="form-control form-control-lg" id="street" placeholder="Enter street"
                    wire:model="street" value="{{ old('street') }}">
                @error('street') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="suburb" class="form-label">Suburb</label>
                <input type="text" class="form-control form-control-lg" id="suburb" placeholder="Enter suburb"
                    wire:model="suburb" value="{{ old('suburb') }}">
                @error('suburb') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="state_province" class="form-label">State/Territory</label>
                <input type="text" class="form-control form-control-lg" id="state_province"
                    placeholder="Enter state/territory" wire:model="state_province" value="{{ old('state_province') }}">
                @error('state_province') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="postcode" class="form-label">Postcode</label>
                <input type="text" class="form-control form-control-lg" id="postcode" placeholder="Enter postcode"
                    wire:model="postcode" value="{{ old('postcode') }}">
                @error('postcode') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-primary" wire:click="step(1)">
                    <i class="fa fa-spinner fa-spin" wire:loading wire:target="step"></i>
                    Previous
                </button>
                <button type="button" class="btn btn-primary" wire:click="secondStepSubmit">
                    <i class="fa fa-spinner fa-spin" wire:loading wire:target="secondStepSubmit"></i>
                    Next
                </button>
            </div>
        </div>
    </div>
    @elseif($currentStep == 3)
    <div class="col-md-4 mx-auto">
        <div id="step3">
            <div class="mb-3">
                <label for="practice_name" class="form-label">Practise Name</label>
                <input type="text" class="form-control form-control-lg" id="practice_name"
                    placeholder="Enter Practise Name" wire:model="practice_name" value="{{ old('practice_name') }}">
                @error('practice_name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="suburb2" class="form-label">Practise Suburb</label>
                <input type="text" class="form-control form-control-lg" id="suburb2" placeholder="Enter Practise suburb"
                    wire:model="suburb2" value="{{ old('suburb2') }}">
                @error('suburb2') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="state_province2" class="form-label">Practise State/Territory</label>
                <input type="text" class="form-control form-control-lg" id="state_province2"
                    placeholder="Enter Practise State/Territory" wire:model="state_province2"
                    value="{{ old('state_province2') }}">
                @error('state_province2') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="postcode2" class="form-label">Practise Postcode</label>
                <input type="text" class="form-control form-control-lg" id="postcode2"
                    placeholder="Enter Practise Postcode" wire:model="postcode2" value="{{ old('postcode2') }}">
                @error('postcode2') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="birth_date" class="form-label">Birth Date</label>
                <input type="date" class="form-control form-control-lg" id="birth_date" placeholder="Enter birth date"
                    wire:model="birth_date" value="{{ old('birth_date') }}">
                @error('birth_date') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="place_of_birth" class="form-label">Place of Birth</label>
                <input type="text" class="form-control form-control-lg" id="place_of_birth"
                    placeholder="Enter place of birth" wire:model="place_of_birth" value="{{ old('place_of_birth') }}">
                @error('place_of_birth') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="spouse_name" class="form-label">Spouse's name</label>
                <input type="text" class="form-control form-control-lg" id="spouse_name"
                    placeholder="Enter spouse's name" wire:model="spouse_name" value="{{ old('spouse_name') }}">
                @error('spouse_name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-primary" wire:click="step(2)">
                    <i class="fa fa-spinner fa-spin" wire:loading wire:target="step"></i>
                    Previous
                </button>
                <button type="button" class="btn btn-primary" wire:click="thirdStepSubmit">
                    <i class="fa fa-spinner fa-spin" wire:loading wire:target="thirdStepSubmit"></i>
                    Next
                </button>
            </div>
        </div>
    </div>
    @elseif($currentStep == 4)
    <div class="col-md-4 mx-auto">
        <div id="step4">
            <div class="mb-3">
                <label for="proposer_name" class="form-label">Proposer name</label>
                <input type="text" class="form-control form-control-lg" id="proposer_name"
                    placeholder="Enter proposer name" wire:model="proposer_name" value="{{ old('proposer_name') }}">
                @error('proposer_name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="seconder_name" class="form-label">Seconder name</label>
                <input type="text" class="form-control form-control-lg" id="seconder_name"
                    placeholder="Enter seconder name" wire:model="seconder_name" value="{{ old('seconder_name') }}">
                @error('seconder_name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="cv_file" class="form-label">C.V. File (Please select a copy of your most recent
                    C.V)</label>
                <input type="file" class="form-control form-control-lg" id="cv_file" placeholder="Enter cv file"
                    wire:model="cv_file" value="{{ old('cv_file') }}">
                @error('cv_file') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="photograph" class="form-label">Photograph (Include a recent photograph of
                    yourself)</label>
                <input type="file" class="form-control form-control-lg" id="photograph" placeholder="Enter photograph"
                    wire:model="photograph" value="{{ old('photograph') }}">
                @error('photograph') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="letter" class="form-label">Letter (Include a letter from your proposer)</label>
                <input type="file" class="form-control form-control-lg" id="letter" placeholder="Enter letter"
                    wire:model="letter" value="{{ old('letter') }}">
                @error('letter') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="letter2" class="form-label">Letter (Include a letter from your seconder)</label>
                <input type="file" class="form-control form-control-lg" id="letter2" placeholder="Enter letter"
                    wire:model="letter2" value="{{ old('letter2') }}">
                @error('letter2') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="degrees_diplomas" class="form-label">Degrees and Diplomas (with dates and
                    locations)</label>
                <textarea class="form-control form-control-lg" id="degrees_diplomas" rows="3"
                    wire:model="degrees_diplomas">{{ old('degrees_diplomas') }}</textarea>
                @error('degrees_diplomas') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="present_surgical_appointments" class="form-label">Present Surgical
                    Appointments</label>
                <textarea class="form-control form-control-lg" id="present_surgical_appointments" rows="3"
                    wire:model="present_surgical_appointments">{{ old('present_surgical_appointments') }}</textarea>
                @error('present_surgical_appointments') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="publications_relevant_to_hand_surgery" class="form-label">Publications Relevant to
                    Hand
                    Surgery</label>
                <textarea class="form-control form-control-lg" id="publications_relevant_to_hand_surgery" rows="3"
                    wire:model="publications_relevant_to_hand_surgery">{{ old('publications_relevant_to_hand_surgery') }}</textarea>
                @error('publications_relevant_to_hand_surgery') <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="areas_of_interest" class="form-label">Areas of interest</label>
                <textarea class="form-control form-control-lg" id="areas_of_interest" rows="3"
                    wire:model="areas_of_interest">{{ old('areas_of_interest') }}</textarea>
                @error('areas_of_interest') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="show_my_details_in_public" class="form-label">Show
                    my
                    details in the Public Hand Surgeons Directory on this site</label>
                <input type="radio" wire:model="show_my_details_in_public" value="Yes"> Yes
                <input type="radio" wire:model="show_my_details_in_public" value="No"> No
                @error('show_my_details_in_public')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="show_my_details_in_private" class="form-label">Show
                    my
                    details in the Private Members Directory on this site</label>
                <input type="radio" wire:model="show_my_details_in_private" value="Yes"> Yes
                <input type="radio" wire:model="show_my_details_in_private" value="No"> No
                @error('show_my_details_in_private')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-primary" wire:click="step(3)">
                    <i class="fa fa-spinner fa-spin" wire:loading wire:target="step"></i>
                    Previous
                </button>
                <button type="button" class="btn btn-primary" wire:click="fourthStepSubmit">
                    <i class="fa fa-spinner fa-spin" wire:loading wire:target="fourthStepSubmit"></i>
                    Next
                </button>
            </div>
        </div>
    </div>
    @elseif($currentStep == 5)
    <div class="col-md-4 mx-auto">
        <div id="step5">
            <div class="mb-3">
                <label for="first_name2" class="form-label">First Name</label>
                <input type="text" class="form-control form-control-lg" id="first_name2" placeholder="Enter first name"
                    wire:model="first_name2" value="{{ old('first_name2') }}">
                @error('first_name2') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="last_name2" class="form-label">Last Name</label>
                <input type="text" class="form-control form-control-lg" id="last_name2" placeholder="Enter last name"
                    wire:model="last_name2" value="{{ old('last_name2') }}">
                @error('last_name2') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="address_1" class="form-label">Address 1</label>
                <input type="text" class="form-control form-control-lg" id="address_1" placeholder="Enter address 1"
                    wire:model="address_1" value="{{ old('address_1') }}">
                @error('address_1') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="address_2" class="form-label">Address 2</label>
                <input type="text" class="form-control form-control-lg" id="address_2" placeholder="Enter address 2"
                    wire:model="address_2" value="{{ old('address_2') }}">
                @error('address_2') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">City</label>
                <input type="text" class="form-control form-control-lg" id="city" placeholder="Enter city"
                    wire:model="city" value="{{ old('city') }}">
                @error('city') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="state" class="form-label">State</label>
                <input type="text" class="form-control form-control-lg" id="state" placeholder="Enter state"
                    wire:model="state" value="{{ old('state') }}">
                @error('state') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="postal_code" class="form-label">Postal Code</label>
                <input type="text" class="form-control form-control-lg" id="postal_code" placeholder="Enter postal code"
                    wire:model="postal_code" value="{{ old('postal_code') }}">
                @error('postal_code') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="country2" class="form-label">Country</label>
                <input type="text" class="form-control form-control-lg" id="country2" placeholder="Enter country"
                    wire:model="country2" value="{{ old('country2') }}">
                @error('country2') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control form-control-lg" id="phone" placeholder="Enter phone"
                    wire:model="phone" value="{{ old('phone') }}">
                @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-primary" wire:click="step(4)">
                    <i class="fa fa-spinner fa-spin" wire:loading wire:target="step"></i>
                    Previous
                </button>
                <button type="button" class="btn btn-primary" wire:click="fifthStepSubmit">
                    <i class="fa fa-spinner fa-spin" wire:loading wire:target="fifthStepSubmit"></i>
                    Next
                </button>
            </div>
        </div>
    </div>
    @elseif($currentStep == 6)
    <div class="col-md-9 mx-auto">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Level</th>
                    <th>Price</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allPlans as $plan)
                <tr class="">
                    <td>{{ $plan->name }}</td>
                    <td>
                        @if($plan->initial_payment == 0)
                        <strong>Free</strong>
                        @else
                        <strong>${{ round($plan->initial_payment, 2) }}</strong> now and then <strong>${{
                            round($plan->billing_amount, 2) }} per Year</strong>.
                        <i class="fa fa-info-circle" title="Plan Info" data-bs-toggle="popover" data-bs-trigger="hover"
                            data-bs-content="${{ round($plan->initial_payment-$plan->billing_amount, 2) }} joining fee and ${{ round($plan->billing_amount, 2) }} per year"></i>
                        @endif
                    </td>
                    <td>
                        <button type="button"
                            class="btn @if($selectedPlan==$plan->id) btn-primary text-white @else btn-outline-primary @endif"
                            wire:click="selectPlan({{ $plan->id }})">
                            @if($selectedPlan==$plan->id)
                            ✓ Selected
                            @else
                            Select
                            @endif
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">No plans found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @error('selectedPlan') <div class="text-danger">{{ $message }}</div> @enderror
        <div class="d-flex justify-content-between mt-4">
            <button type="button" class="btn btn-primary" wire:click="step(5)">Previous</button>
            <button type="button" class="btn btn-primary" wire:click="submit" wire:loading.disable>
                <i class="fa fa-spinner fa-spin" wire:loading wire:target="submit"></i>
                Submit
            </button>
        </div>
    </div>
    @elseif($currentStep == 7)
    <div class="col-md-9 mx-auto">
        <div class="alert alert-success">
            <h4 class="alert-heading">Thank You!</h4>
            <p>Your submission has been received and will be reviewed by the
                Board of AHSS.</p>
            <p>New members are accepted after the AGM each year. You will
                be notified at that time of next steps.</p>
            <hr>
            <p class="mb-0">Having trouble? <a href="mailto:admin@ahss.org.au">Contact us</a></p>
        </div>
    </div>
    @endif
</form>