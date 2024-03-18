@extends('layouts.app')
@section('page')

<link rel="stylesheet" href="css/prescription.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    integrity="sha512-...." crossorigin="anonymous" />
<div class="section mt-4 table-responsive custom-border pfrom">
    <form class="custom-container " action='create-medicine' method='post' enctype='multipart/form-data'>
    @csrf
        <!-- Patient Information -->
        <div class="row d-flex align-items-center">
            <div class="col-md-2 navbar-brand brand-logo img-circle elevation-2">
                <img src="{{ asset('assets/images/hospital1.png') }}" class="rounded-circle shadow float-middle" alt="Hospital Logo" style="height: 90px; width: 90px;">
            </div>
            <div class="col-md-8 text-center">
                <address>
                    <h3>MODERNA CARE HOSPITAL</h3>
                    Panthopath, Dhaka</br>
                    Mobile: 017834433</br>
                    Email: mhms@ihospital.com</br>
                </address>
            </div>
        </div>


        <div class="row ">

            <div class="col-md-4 form-group" style="margin-left:60px;">
                <label for="cmbDoctors">Doctor</label>
                <address>

                    <?php
                    // echo Doctor::html_select("cmbDoctors");
                    ?>
                    <select id="cmbDoctors" name="cmbDoctors">
                    @foreach($doctors as $doctor)
                      <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                    @endforeach
                    </select>

                    <div id="doctor-info"></div>

                </address>
            </div>




            <div class="col-md-4 ">
                <label for="cmbPatients">Patient</label>
                <address class="form-group">

                    <?php
                    //echo Patient::html_select("cmbPatients");
                    ?>

                    <select id="cmbPatients" name="cmbPatients">
                    @foreach($patients as $patient)
                      <option value="{{$patient->id}}">{{$patient->name}}</option>
                    @endforeach
                    </select>

                    <div id="patient-info"></div>

                </address>
            </div>

            <div class="col-md-2 " style="margin-left:70px;">
                <div><label for="txtPrescriptionDate">Date</label></div>
                <input class="form-group" type="text" style="width:120px" id="txtPrescriptionDate"
                    value="<?php echo date("d-m-Y"); ?>" readonly />
                <div><label for="prescriptionId">PID</label> <input class="form-group" type="text" style="width:40px"
                        value="4 " readonly /></div>
                        <!-- //< ?php //echo Prescription::get_last_id() + 1; ?> -->

            </div>
        </div>






        <hr>
        <div class="row mt-3 table-responsive">

            <i class="fas fa-prescription" style='font-size:40px;'> :</i>
            <!-- Left Column -->
            <div class="col-md-4 custom-border" style="margin-left: 60px;">
                <label for="cc" class="form-label">C/C</label>
                <textarea class="form-control" id="cc" rows="6"></textarea>

                <!-- Add Advice Section -->
                <label for="advice" class="form-label mt-3">Advice</label>
                <textarea class="form-control" id="advice" rows="4"></textarea>
                <!-- Follow Up -->
                <label for="followUp" class="form-label">Follow Up</label>
                <textarea class="form-control" id="followUp" rows="2"></textarea>
            </div>

            <!-- Right Column -->
            <div class="col-md-7">

                <div class="row mt-3 custom-border table-responsive">
                    <h3 class="text-center">Medicines</h3>

                    <table class="table" id="medicinesDetails">
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>MEDICINE</th>
                                <th>DOSAGE</th>
                                <th>DAYS</th>
                                <th>INSTRUCTIONS</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="medicines"> </tbody>

                        <tr>
                            <th></th>
                            <th class="medicinesdetails">
                                <?php //echo Medicine::html_select("cmbMedicines"); ?>

                                <select id="cmbMedicines" name="cmbMedicines">
                                    @foreach($medicines as $medicine)
                                    <option value="{{$medicine->id}}">{{$medicine->name}}</option>
                                    @endforeach
                                </select>

                            </th>
                            <th>
                                <input class="form-control " id="txtDosage" type="text" placeholder="1+0+1">
                            </th>
                            <th>
                                <input class="form-control " id="txtDays" type="text" placeholder="7 Days">
                            </th>
                            <th>
                                <input class="form-control " id="txtInstructions" type="text" placeholder="After Food">
                            </th>

                        </tr>


                    </table>
                    <th> <input class="btn btn-primary btn-add" type="button" id="btnAddMedicine" value="+">
                    </th>
                </div>

            </div>

            <div class="row mt-4">
                <div class="col-6 btn-group float-end">
                    <button href="javascript:void(0)" onclick="window.print()" rel="noopener" target="_blank" type="button"  id="btnPrint" class="btn btn-info"><i class="fas fa-print"></i>
                        Print Prescription</button>
                    <button type="button" id="btnsavepres" class="btn btn-success"><i
                            class="fas fa-prescription"></i> Process Prescription</button>
                    <!-- <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;"><i
                            class="fas fa-download"></i> Generate PDF</button> -->
                </div>                
            </div>
            <div> <a class="btn btn-secondary float-end" href="{{url('prescriptions')}}">Manage Prescription</a></div>            
        </div>
    </form>
    
</div>

<script>

    $(function () {

        printCart();
        $("#btnsavepres").on("click", function () {

            if (confirm("Are you sure?")) {

                let doctor_id = $("#cmbDoctors").val();
                let patient_id = $("#cmbPatients").val();
                let prescription_date = $("#txtPrescriptionDate").val();
                let cc = $("#cc").val();
                let advice = $("#advice").val();
                let followUp = $("#followUp").val();
                let pres_medicines = medicines;

                let _data = {
                    "doctor_id": doctor_id,
                    "patient_id": patient_id,
                    "prescription_date": prescription_date,
                    "cc": cc,
                    "advice": advice,
                    "followUp": followUp,
                    "pres_medicines": medicines
                }

                //console.log(_data);

                $.ajax({
                    url: 'api/Prescription/save',
                    type: 'POST',
                    data: _data,
                    success: function (res) {
                        console.log(res);

                        $("#medicines").html("");

                        location.reload();
                    }
                });

            }

        });





        $("#cmbDoctors").on("change", function () {
            $.ajax({
                url: 'api/Doctor/find',
                type: 'GET',
                data: {
                    "id": $(this).val()
                },
                success: function (res) {
                    let data = JSON.parse(res);
                    //console.log(data.doctor);
                    let doctor = data.doctor;

                    $("#doctor-info").html(`<p class="mb-1"><strong>Designation: </strong>${doctor.designation}</p>
                    <p class="mb-1"><strong>Phone: </strong>${doctor.phone_number}</p>
                    <p class="mb-1"><strong>Email: </strong>${doctor.email}</p>`)
                }
            });
        });

        $("#cmbPatients").on("change", function () {
            $.ajax({
                url: 'api/Patient/findDetails',
                type: 'GET',
                data: {
                    "id": $(this).val()
                },
                success: function (res) {
                    let data = JSON.parse(res);
                    //console.log(data.patient);
                    let patient = data.patient;

                    let dob = new Date(patient.dob);
                    let today = new Date();
                    let ageInMonths = (today.getFullYear() - dob.getFullYear()) * 12 + (today.getMonth() - dob.getMonth());
                    let years = Math.floor(ageInMonths / 12);
                    let months = ageInMonths % 12;

                    $("#patient-info").html(`<p class="mb-1"><strong>Gender: </strong>${patient.gender}</p>
                    <p class="mb-1"><strong>Contact: </strong>${patient.contact_number} </p>
                    <p class="mb-1"><strong>Email: </strong>${patient.email} </p>
                    <p class="mb-1"><strong>Age: </strong>${years} years and ${months} months</p>`);
                }
            });
        });



        var medicines = [];

        // Add medicine to the list
        $("#btnAddMedicine").on("click", function () {
            let name = $("#cmbMedicines option:selected").text();
            let medicine_id = $("#cmbMedicines").val();
            let dosage = $("#txtDosage").val();
            let days = $("#txtDays").val();
            let instructions = $("#txtInstructions").val();

            let medicine = {
                "name": name,
                "medicine_id": medicine_id,
                "dosage": dosage,
                "days": days,
                "instructions": instructions
            };

            medicines.push(medicine);

            printMedicineList(medicines);
            // Clear the input fields
            // $("#cmbDoctors").val("");
            // $("#cmbPatients").val("");
            // $("#cc").val("");
            // $("#advice").val("");
            // $("#followup").val("");
            $("#cmbMedicines").val("");  // Clear the selected medicine
            $("#txtDosage").val("");
            $("#txtDays").val("");
            $("#txtInstructions").val("");
        });

        // Delete medicine from the list
        $("body").on("click", ".deleteMedicine", function () {
            let medicine_id = $(this).data("id");

            medicines = medicines.filter(medicine => {
                return medicine.medicine_id != medicine_id;
            });

            printMedicineList(medicines);
        });

        $("#clearAllMedicines").on("click", function () {
            medicines = [];

        });

        //------------------Medicine List Functions----------//

        function printMedicineList(medicines) {
            let sn = 1;
            $("#medicines").html("");

            medicines.forEach(function (medicine) {
                $("#medicines").append(`<tr>
            <td>${sn++}</td>
            <td>${medicine.name}</td>
            <td>${medicine.dosage}</td>
            <td>${medicine.days}</td>
            <td>${medicine.instructions}</td>
            <td><input class='deleteMedicine btn btn-danger' type='button' value='Del' data-id='${medicine.medicine_id}'/></td>
        </tr>`);
            });
        }

        $(document).ready(function () {
            // Existing code...

            // Function to generate and print prescription
            $("#btnPrint").on("click", async function () {
                // Call a function to collect and construct prescription details
                let prescriptionContent = await generatePrescriptionContent();
                savePrescriptionData();
                // Open a new window and set the content for printing
                let printWindow = window.open('', '_blank');
                printWindow.document.write(prescriptionContent);
                printWindow.document.close();

                // Print the window
                printWindow.print();
                location.reload();
            });
            function savePrescriptionData() {
                let doctor_id = $("#cmbDoctors").val();
                let patient_id = $("#cmbPatients").val();
                let prescription_date = $("#txtPrescriptionDate").val();
                let cc = $("#cc").val();
                let advice = $("#advice").val();
                let followUp = $("#followUp").val();
                let pres_medicines = medicines;

                let _data = {
                    "doctor_id": doctor_id,
                    "patient_id": patient_id,
                    "prescription_date": prescription_date,
                    "cc": cc,
                    "advice": advice,
                    "followUp": followUp,
                    "pres_medicines": pres_medicines
                };

                // Save data using AJAX
                $.ajax({
                    url: 'api/Prescription/save',
                    type: 'POST',
                    data: _data,
                    success: function (res) {
                        console.log("Prescription data saved successfully.");
                    },
                    error: function (err) {
                        console.error("Error saving prescription data:", err);
                    }
                });
            };

            // Function to collect and construct prescription details
            async function generatePrescriptionContent() {
                // Fetch and format doctor information
                let doctorId = $("#cmbDoctors").val();
                let doctorInfo = await getDoctorInfo(doctorId);

                // Fetch and format patient information
                let patientId = $("#cmbPatients").val();
                let patientInfo = await getPatientInfo(patientId);

                // Collect CC, Advice, Follow Up information
                let cc = $("#cc").val();
                let advice = $("#advice").val();
                let followUp = $("#followUp").val();

                // Collect medicines details
                let medicinesTable = $("#medicinesDetails").clone();
                medicinesTable.find("tr:last").remove();
                medicinesTable.find(".deleteMedicine").remove();
                medicinesTable.find("th:last").remove();
                medicinesTable.find("thead").remove();



                // Construct the prescription content
                let prescriptionContent = `
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <style>
                    /* Add your custom styles here */
                    body {
                        font-family: 'Times New Roman', sans-serif;
                        size: A4; /* Set the size to A4 or letter based on your preference */
                    }
                    .prescription {
                        display:inline;
                        align-items:center;
                        margin: 20px;
                    }
                    .doctor-patient-info {
                        display: flex;
                        justify-content: space-between;
                    }
                    .info-column {
                        width: 48%; /* Adjust as needed */
                    }
                    .medicines-table {
                        width: 70%;
                        margin-top: 20px;
                    }
                    a {
                display: none !important;
            }
                </style>
            </head>
            <body>
            <div class="prescription">
            <table style="width: 100%; border: none;">
    <tr>
        <td style="width: 33.33%; text-align: left;">
            <img src="api/img/MHMSlogo.png" alt="Hospital Logo" style="height: 80px; width: 80px;">
        </td>
        <td style="width: 33.33%; text-align: center;">
            <address>
                <h3>MODERN HOSPITAL</h3>
                Panthopath, Dhaka<br>
                Mobile: 017834433<br>
                Email: mhms@ihospital.com<br>
            </address>
        </td>
        <td style="width: 33.33%; text-align: right;">
                  <p><strong>Prescription ID:</strong> <?php //echo Prescription::get_last_id() + 1; ?></p>
                 <p><strong>Date:</strong> <?php echo date("d-m-Y"); ?> </p>
                  </td>
                  </tr>
            </table>



                    
                    <div class="doctor-patient-info">
                        <div class="info-column">
                            <h5>Doctor Information</h5>
                            ${doctorInfo}
                        </div>
                        <div class="info-column">
                            <h5>Patient Information</h5>
                            ${patientInfo}
                        </div>
                    </div>
                    <hr>
                    <div class="row mt-3 ">
                    <span style="font-size:40px;">&#8478;</span>
                        <div class="col-6" style=" margin-left:20px;">
                            
                            <p><strong>CC:</strong> ${cc}</p>
                            <p><strong>Advice:</strong> ${advice}</p>
                            <p><strong>Follow Up:</strong> ${followUp}</p>
                        </div>
                        <div class="col-4" style="text-align:center;">
                            <h3>Medicines</h3>
                            <table class="table medicines-table" style="text-align:center; margin-left:90px;">
                            <tr>
                                <td>SN</td>
                                <td>MEDICINE</td>
                                <td>DOSAGE</td>
                                <td>DAYS</td>
                                <td>INSTRUCTIONS</td>
                                
                            </tr>
                            <tbody>
                           
                            ${medicinesTable.html()}
                      
                            </tbody>
                            </table>
                        </div>
                        <h3 style="margin-top:40px">Signature</h3>
                    </div>
                </div>
            </body>
            </html>
        `;

                return prescriptionContent;
            }

            // Function to get doctor information
            async function getDoctorInfo(doctorId) {
                return new Promise(function (resolve, reject) {
                    $.ajax({
                        url: 'api/Doctor/find',
                        type: 'GET',
                        data: {
                            "id": doctorId
                        },
                        success: function (res) {
                            let data = JSON.parse(res);
                            let doctor = data.doctor;

                            let doctorInfo = `
                        <p><strong>Doctor Name:</strong> ${doctor.name}</p>
                        <p><strong>Designation:</strong> ${doctor.designation}</p>
                        <p><strong>Email:</strong> ${doctor.email}</p>
                        <p><strong>Phone:</strong> ${doctor.phone_number}</p>
                    `;
                            resolve(doctorInfo);
                        },
                        error: function (err) {
                            reject(err);
                        }
                    });
                });
            }

            // Function to get patient information
            async function getPatientInfo(patientId) {
                return new Promise(function (resolve, reject) {
                    $.ajax({
                        url: 'api/Patient/findDetails',
                        type: 'GET',
                        data: {
                            "id": patientId
                        },
                        success: function (res) {
                            let data = JSON.parse(res);
                            let patient = data.patient;

                            let dob = new Date(patient.dob);
                            let today = new Date();
                            let ageInMonths = (today.getFullYear() - dob.getFullYear()) * 12 + (today.getMonth() - dob.getMonth());
                            let years = Math.floor(ageInMonths / 12);
                            let months = ageInMonths % 12;

                            let patientInfo = `
                        <p><strong>Patient Name:</strong> ${patient.name}</p>
                        <p><strong>Gender:</strong> ${patient.gender}</p>
                        <p><strong>Contact:</strong> ${patient.contact_number}</p>
                        <p><strong>Email:</strong> ${patient.email}</p>
                        <p><strong>Age:</strong> ${years} years and ${months} months</p>
                    `;
                            resolve(patientInfo);
                        },
                        error: function (err) {
                            reject(err);
                        }
                    });
                });
            }
        });

    })
</script>

  
@endsection