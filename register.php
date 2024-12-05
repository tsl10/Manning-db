<?php
include 'inc/header.php';
Session::CheckLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $register = $users->userRegistration($_POST);
    if ($register) {
        echo $register;
    }
}
?>

<div class="card">
    <div class="card-header">
        <h3 class='text-center'>User Registration</h3>
        <!-- Progress bar -->
        <div class="progress">
            <div id="progress-bar" class="progress-bar bg-success" role="progressbar" style="width: 44%;" aria-valuenow="44" aria-valuemin="0" aria-valuemax="100">44%</div>
        </div>
    </div>
    <div class="card-body">
        <div style="width:600px; margin:0 auto">
            <form id="registrationForm" action="" method="post" enctype="multipart/form-data">
                <!-- Step 1 -->
                <div class="step" id="step1">
                    <h5 class="mb-3">Basic Information</h5>
                    <div class="form-group pt-3">
                        <label for="name">Your Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <div style="display: flex;">
                            <select id="country_code" name="country_code" class="form-control" style="width: 100px;" required>
                                <option value="+1">+1 (USA)</option>
                                <option value="+44">+44 (UK)</option>
                                <option value="+91">+91 (India)</option>
                                <option value="+852">+852 (HK)</option>
                            </select>
                            <input type="text" name="mobile" class="form-control" maxlength="10" pattern="\d{10}" title="Enter a valid 10-digit mobile number" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-primary next-step">Continue to Next Step</button>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="step d-none" id="step2">
                    <h5 class="mb-3">Job Application Details</h5>
                    <div class="form-group">
                        <label for="date_available">Date Available</label>
                        <input type="date" name="date_available" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="position_applied">Position Applied For</label>
                        <input type="text" name="position_applied" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="surname">Surname</label>
                        <input type="text" name="surname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="middle_names">Middle Name(s)</label>
                        <input type="text" name="middle_names" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="photo">Attach Photo</label>
                        <input type="file" name="photo" class="form-control" accept="image/*" required>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary prev-step">Previous</button>
                        <button type="button" class="btn btn-primary next-step">Continue</button>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="step d-none" id="step3">
                    <h5 class="mb-3">Personal Details</h5>
                    <div class="form-group">
                        <label for="dob">Date of Birth</label>
                        <input type="date" name="dob" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="place_of_birth">Place of Birth</label>
                        <input type="text" name="place_of_birth" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nationality">Nationality</label>
                        <input type="text" name="nationality" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="height">Height</label>
                        <input type="text" name="height" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="weight">Weight</label>
                        <input type="text" name="weight" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="hair_colour">Hair Colour</label>
                        <input type="text" name="hair_colour" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="eye_colour">Eye Colour</label>
                        <input type="text" name="eye_colour" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="marital_status">Marital Status</label>
                        <input type="text" name="marital_status" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="spouse_name">Spouse’s Name</label>
                        <input type="text" name="spouse_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="children_count">No. of Children</label>
                        <input type="number" name="children_count" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="father_name">Father’s Name</label>
                        <input type="text" name="father_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="mother_name">Mother’s Name</label>
                        <input type="text" name="mother_name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="next_of_kin">Next of Kin</label>
                        <input type="text" name="next_of_kin" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="home_address">Home Address</label>
                        <input type="text" name="home_address" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="home_tel_no">Tel. No. (Home)</label>
                        <input type="text" name="home_tel_no" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="other_address">Other Address</label>
                        <input type="text" name="other_address" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="other_tel_no">Tel. No. (Other)</label>
                        <input type="text" name="other_tel_no" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" name="email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="skype">Skype</label>
                        <input type="text" name="skype" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="homeport">Homeport</label>
                        <input type="text" name="homeport" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="mob_no">Mob No.</label>
                        <input type="text" name="mob_no" class="form-control">
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary prev-step">Previous</button>
                        <button type="button" class="btn btn-primary next-step">Continue</button>
                    </div>
                </div>

             <!-- Step 4 -->
             <div class="step d-none" id="step4">
                    <h5 class="mb-3">Licenses/Documents Held</h5>
                    <!-- Repeat this structure for each document -->
                    <div class="form-group">
                        <label for="national_licence">National Licence</label>
                        <input type="text" name="national_licence_item_no" class="form-control" placeholder="Item No.">
                        <input type="text" name="national_licence_issued_date" class="form-control" placeholder="Issued Date">
                        <input type="text" name="national_licence_place" class="form-control" placeholder="Place">
                        <input type="text" name="national_licence_by" class="form-control" placeholder="By">
                        <input type="text" name="national_licence_expiry_date" class="form-control" placeholder="Expiry Date">
                        <input type="text" name="national_licence_grade" class="form-control" placeholder="Grade">
                    </div>
                    <!-- Repeat for each document like STCW Endorsement, Passport, etc. -->
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary prev-step">Previous</button>
                        <button type="submit" name="register" class="btn btn-success">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const steps = document.querySelectorAll('.step');
    let currentStep = 0;
    const progressBar = document.getElementById('progress-bar');
    const submitBtn = document.getElementById('submitBtn');
    
    // Initially set progress bar to 0%
    updateProgressBar();

    document.querySelectorAll('.next-step').forEach(button => {
        button.addEventListener('click', function () {
            if (validateCurrentStep()) {
                // Hide the current step and show the next one
                steps[currentStep].classList.add('d-none');
                currentStep++;
                steps[currentStep].classList.remove('d-none');

                // Update progress bar
                updateProgressBar();

                if (currentStep === steps.length) {
                    submitBtn.style.display = 'block'; // Show submit button on final step
                }
            } else {
                alert('Please fill out all required fields.');
            }
        });
    });

    document.querySelectorAll('.prev-step').forEach(button => {
        button.addEventListener('click', function () {
            // Hide the current step and show the previous one
            steps[currentStep].classList.add('d-none');
            currentStep--;
            steps[currentStep].classList.remove('d-none');

            // Update progress bar
            updateProgressBar();

            if (currentStep !== steps.length) {
                submitBtn.style.display = 'none'; // Hide submit button
            }
        });
    });

    function validateCurrentStep() {
        const currentInputs = steps[currentStep].querySelectorAll('input, select');
        let valid = true;

        currentInputs.forEach(input => {
            if (!input.value) {
                valid = false;
                input.style.borderColor = 'red';
            } else {
                input.style.borderColor = '';
            }
        });
        return valid;
    }

    function updateProgressBar() {
        // Set progress in increments of 10% for each step
        const percentage = currentStep * 10; 
        progressBar.style.width = percentage + '%';
        progressBar.setAttribute('aria-valuenow', percentage);
        progressBar.textContent = Math.round(percentage) + '%';
    }
});
</script>




<?php include 'inc/footer.php'; ?>
