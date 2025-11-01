<?php
/**
 * Test page for custom CHBS form
 * Visit: http://localhost:10003/test-custom-form.php
 */

// Load WordPress
require_once('wp-load.php');

// Get header
get_header();
?>

<style>
.test-container {
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
}

.custom-booking-form {
    background: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 2px 20px rgba(0,0,0,0.1);
}

.form-step {
    display: none;
}

.form-step.active {
    display: block;
}

.form-row {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.form-col {
    flex: 1;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 12px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 16px;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #3cb371;
    outline: none;
}

.btn-primary {
    background: #3cb371;
    color: white;
    padding: 15px 40px;
    border: none;
    border-radius: 30px;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-primary:hover {
    background: #2ea25f;
    transform: translateY(-2px);
    box-shadow: 0 5px 20px rgba(60, 179, 113, 0.3);
}

.step-indicator {
    display: flex;
    justify-content: center;
    margin-bottom: 40px;
    gap: 20px;
}

.step-dot {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e0e0e0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: #666;
}

.step-dot.active {
    background: #3cb371;
    color: white;
}
</style>

<div class="test-container">
    <h1 style="text-align: center; margin-bottom: 40px;">Custom CHBS Booking Form Test</h1>
    
    <div class="custom-booking-form">
        <!-- Step Indicator -->
        <div class="step-indicator">
            <div class="step-dot active">1</div>
            <div class="step-dot">2</div>
            <div class="step-dot">3</div>
        </div>

        <form id="custom-chbs-form" name="chbs-form" method="post">
            <!-- Hidden CHBS Fields -->
            <input type="hidden" name="action" value="">
            <input type="hidden" name="booking_form_id" value="10007">
            <input type="hidden" name="chbs_service_type_id" value="1">
            <input type="hidden" name="step_request" value="1">
            
            <!-- Step 1: Trip Details -->
            <div class="form-step active" data-step="1">
                <h2>Where would you like to go?</h2>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label>Pickup Location *</label>
                            <input type="text" name="chbs_pickup_location_service_type_1" placeholder="Enter pickup address" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label>Drop-off Location *</label>
                            <input type="text" name="chbs_dropoff_location_service_type_1" placeholder="Enter destination" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label>Pickup Date *</label>
                            <input type="date" name="chbs_pickup_date_service_type_1" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label>Pickup Time *</label>
                            <input type="time" name="chbs_pickup_time_service_type_1" value="10:00" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label>Number of Passengers *</label>
                            <select name="chbs_passenger_adult_service_type_1">
                                <option value="1">1 Passenger</option>
                                <option value="2">2 Passengers</option>
                                <option value="3">3 Passengers</option>
                                <option value="4" selected>4 Passengers</option>
                                <option value="5">5 Passengers</option>
                                <option value="6">6 Passengers</option>
                                <option value="7">7 Passengers</option>
                                <option value="8">8 Passengers</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 30px;">
                    <button type="button" class="btn-primary" onclick="showStep(2)">
                        Continue to Vehicle Selection
                    </button>
                </div>
            </div>
            
            <!-- Step 2: Vehicles -->
            <div class="form-step" data-step="2">
                <h2>Choose your vehicle</h2>
                
                <div id="vehicle-list">
                    <p>Loading vehicles...</p>
                </div>
                
                <div style="text-align: center; margin-top: 30px;">
                    <button type="button" class="btn-primary" onclick="showStep(1)" style="background: #666;">
                        Back
                    </button>
                    <button type="button" class="btn-primary" onclick="showStep(3)">
                        Continue to Contact Details
                    </button>
                </div>
            </div>
            
            <!-- Step 3: Contact -->
            <div class="form-step" data-step="3">
                <h2>Your contact information</h2>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label>First Name *</label>
                            <input type="text" name="chbs_client_contact_detail_first_name" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label>Last Name *</label>
                            <input type="text" name="chbs_client_contact_detail_last_name" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label>Email Address *</label>
                            <input type="email" name="chbs_client_contact_detail_email_address" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="tel" name="chbs_client_contact_detail_phone_number">
                        </div>
                    </div>
                </div>
                
                <div style="text-align: center; margin-top: 30px;">
                    <button type="button" class="btn-primary" onclick="showStep(2)" style="background: #666;">
                        Back
                    </button>
                    <button type="submit" class="btn-primary">
                        Complete Booking
                    </button>
                </div>
            </div>
        </form>
        
        <div id="debug-info" style="margin-top: 40px; padding: 20px; background: #f0f0f0; border-radius: 8px;">
            <h3>Debug Information:</h3>
            <p>AJAX URL: <?php echo admin_url('admin-ajax.php'); ?></p>
            <p>CHBS Plugin Active: <?php echo class_exists('CHBSBookingForm') ? 'Yes' : 'No'; ?></p>
            <p>Form IDs Found: <?php 
                global $wpdb;
                $forms = $wpdb->get_results("SELECT ID, post_title FROM {$wpdb->posts} WHERE post_type = 'chbs_booking_form' AND post_status = 'publish'");
                foreach($forms as $form) {
                    echo $form->ID . ' (' . $form->post_title . ') ';
                }
            ?></p>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    // Simple step navigation
    window.showStep = function(step) {
        $('.form-step').removeClass('active');
        $('.form-step[data-step="' + step + '"]').addClass('active');
        
        $('.step-dot').removeClass('active');
        $('.step-dot:nth-child(' + step + ')').addClass('active');
        
        // Load vehicles on step 2
        if (step == 2) {
            loadVehicles();
        }
    };
    
    // Load vehicles
    function loadVehicles() {
        $('#vehicle-list').html('<p>Loading vehicles...</p>');
        
        // Try AJAX call to CHBS
        var formData = $('#custom-chbs-form').serialize();
        formData += '&action=chbs_go_to_step&step_request=2';
        
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log('AJAX Response:', response);
                $('#vehicle-list').html('<pre>' + JSON.stringify(response, null, 2) + '</pre>');
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error:', error);
                $('#vehicle-list').html('<p>Error loading vehicles: ' + error + '</p>');
            }
        });
    }
    
    // Form submission
    $('#custom-chbs-form').on('submit', function(e) {
        e.preventDefault();
        alert('Form submitted! Check console for data.');
        console.log('Form Data:', $(this).serialize());
    });
    
    // Convert date format for CHBS (DD-MM-YYYY)
    $('input[type="date"]').on('change', function() {
        var date = new Date($(this).val());
        var formatted = ('0' + date.getDate()).slice(-2) + '-' + 
                       ('0' + (date.getMonth() + 1)).slice(-2) + '-' + 
                       date.getFullYear();
        console.log('Date formatted for CHBS:', formatted);
    });
});
</script>

<?php
get_footer();
?>
