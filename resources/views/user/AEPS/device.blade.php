<script>
function toggleDeviceButtons() {
    const selectedDevice = document.getElementById('deviceSelector').value;

    // Hide all buttons first
    document.getElementById('mantraBtn').classList.add('d-none');
    document.getElementById('mtrCaptureBtn').classList.add('d-none');
    document.getElementById('btn1').classList.add('d-none');
    document.getElementById('btn3').classList.add('d-none');

    
    // Show and auto-run based on selection
    if (selectedDevice === 'mantra') {
        document.getElementById('mantraBtn').classList.remove('d-none');
        document.getElementById('mtrCaptureBtn').classList.remove('d-none');
        discoverAvdm(); // Auto run
    } else if (selectedDevice === 'morpho') {
        document.getElementById('btn1').classList.remove('d-none');
        document.getElementById('btn3').classList.remove('d-none');
        RDService(); // Auto run
    }
}

// You should call this inside your real CaptureAvdm or Capture success
function onCaptureSuccess() {
    
}

// Dummy examples — replace with actual logic
function discoverAvdm() {
    console.log("Running Mantra RD discovery...");
    // Simulate async work
    setTimeout(() => {
        console.log("Mantra RD ready");
    }, 1000);
}

function RDService() {
    console.log("Running Morpho RD service check...");
    // Simulate async work
    setTimeout(() => {
        console.log("Morpho RD ready");
    }, 1000);
}

// Simulated capture functions
function CaptureAvdm() {
    console.log("Mantra Capture started...");
    setTimeout(() => {
        console.log("Mantra Capture done.");
        onCaptureSuccess();
    }, 1000);
}

function Capture() {
    console.log("Morpho Capture started...");
    setTimeout(() => {
        console.log("Morpho Capture done.");
        onCaptureSuccess();
    }, 1000);
}
</script>


<script>
// Wait until the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    // Check if Geolocation is supported
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            // Success callback
            (position) => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;

                // Fill in the form fields if they exist
                const latInput = document.getElementById('latitude');
                const longInput = document.getElementById('longitude');
                
                if (latInput) latInput.value = latitude;
                if (longInput) longInput.value = longitude;
            },
            // Error callback
            (error) => {
                console.error('Error getting location:', error.message);
                alert('Unable to fetch location. Please enable location services.');
            }
        );
    } else {
        alert('Geolocation is not supported by your browser.');
    }
});
</script>

{{-- <script>

    // @include('user.AEPS.morpho');

// window.onload = async function () {

    // Geolocation API to auto-fetch latitude and longitude
    document.addEventListener('DOMContentLoaded', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                },
                (error) => {
                    console.error('Error getting location:', error);
                    alert('Unable to fetch location. Please enable location services.');
                }
            );
        } else {
            alert('Geolocation is not supported by your browser.');
        }
    });
</script> --}}


{{-- bio Data --}}

<div >

</div>




</div>
<!-- <div>
    <h4 >Initialized Framework</h4>
    <div>
        <button type="button" onclick="discoverAvdm();" type="button" value="Discover AVDM">Discover AVDM</button>

        <button type="button" value="Device Info" onclick="deviceInfoAvdm();">Device Info</button>

        <button type="button" value="Capture" onclick="CaptureAvdm();">Capture</button>

        <button type="button" onclick="reset();" value="Reset">Reset</button>
        &nbsp;&nbsp;
</div> -->
<!-- <div>
    <textarea id="txtPidData" rows="7"></textarea>
</div> -->
<div">
<section  style="display:none">


<div id="wrapper" >
    <div id="myNav">
        <div>
            <a href="#">Please wait while discovering port from 11100 to 11120.This will take some time.</a>
        </div>
    </div>
    <!-- Navigation -->
    <div  role="navigation">
        <div>
            <a><img src="logo.png" alt="Mantra logo"></a>
        </div>
        <!-- /.navbar-header -->

        <div>
            <h2>Mantra RD Service Call</h2>
        </div>
    </div>
    
    
    <div>

                                        <div>
                                            <label> Custom SSL Certificate Domain Name  Ex:(rd.myservice.com) </label>
                                            <input type="text" id="txtSSLDomName" placeholder="127.0.0.1">
                                        </div>
                                        </div>
                                </div>
                                <div>

                                        <div>
                                            <label ><b>[ After binding custom SSL certificate, add your domain name in hosts file  (C:\Windows\System32\drivers\etc\hosts)</b></label>
                                            <label><b>Ex: 127.0.0.1   rd.myservice.com ]</b></label>
                                        </div>
                                        </div>
                                </div>
    
    <div>
        <!-- /.row -->
        <div>
            <div>
                <div>

                    <!-- <h4>Initialized Framework</h4>
                    <div>
                        <button type="button" onclick="discoverAvdm();" type="button" value="Discover AVDM">Discover AVDM</button>

                        <button type="button" value="Device Info" onclick="deviceInfoAvdm();">Device Info</button>

                        <button type="button" value="Capture" onclick="CaptureAvdm();">Capture</button>

                        <button type="button" onclick="reset();" value="Reset">Reset</button>
                        &nbsp;&nbsp; -->
                        
                        <!-- <input   name="ChkRD" id="chkHttpsPort" type="checkbox">Custome Port For HTTPS</input> -->
                        {{-- <input   name="ChkRD" id="chkHttpsPort" type="checkbox"></input> --}}
                        
                    </div>



                </div>
            </div>

            <div style="display:none">
                <div>
                    <div>
                        Select Option to Capture
                    </div>
                    <div>
                        <div>
                            <div>
                                <div>
                                    <label>AVDM</label>
                                    <select id="ddlAVDM">
                                        <option></option>
                                    </select>
                                </div>
                                <div>
                                    <div>
                                        <div>
                                            <label>Timeout</label>
                                            <select id="Timeout">
                                                <option>10000</option>
                                                <option>11000</option>
                                                <option>12000</option>
                                                <option>13000</option>
                                                <option>14000</option>
                                                <option>15000</option>
                                                <option>16000</option>
                                                <option>17000</option>
                                                <option>18000</option>
                                                <option>19000</option>
                                                <option>20000</option>
                                                <option>30000</option>
                                                <option>40000</option>
                                                <option>50000</option>
                                                <option>60000</option>
                                                <option>70000</option>
                                                <option>80000</option>
                                                <option>90000</option>
                                                <option>100000</option>
                                                <option>0</option>
                                            </select>
                                        </div>


                                    </div>


                                    <div>
                                        <div>
                                            <label>PidVer</label>
                                            <select id="Pidver">
                                                <option>2.0</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <div>
                                            <label>Env</label>
                                            <select id="Env">
                                                <option>S</option>
                                                <option >PP</option>
                                                <option selected="true">P</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>


                                <div>
                                    <div>
                                        <div>
                                            <label>PTimeout</label>
                                            <select id="pTimeout">
                                                <option>10000</option>
                                                <option selected="selected">20000</option>
                                                <option>30000</option>
                                                <option>40000</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <div>
                                            <label>PGCount</label>
                                            <select id="pgCount">
                                                <option>1</option>
                                                <option selected="selected">2</option>
                                            </select>
                                        </div>
                                    </div>


                                </div>




                            </div>
                            <div>

                                <div >
                                    <label>DataType</label>
                                    <select id="Dtype">
                                        <option value="0">X</option>
                                        <option value="1">P</option>

                                    </select>
                                </div>

                                <div>
                                    <label>Client Key</label>
                                    <input id="txtCK"  type="text" placeholder="Enter text">
                                </div>

                                <div>
                                    <label>OTP</label>
                                    <input id="txtotp"  type="text" placeholder="Enter text">
                                </div>

                            </div>

                            <div>
                                <div>
                                    <label>Wadh</label>
                                    <textarea id="txtWadh" rows="3"></textarea>
                                </div>

                            </div>
                            <div >
                                <div>
                                    <div>
                                        <div>
                                            <label>Finger Count</label>
                                            <select id="Fcount">
                                                <option>0</option>
                                                <option selected="selected">1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                                <option>6</option>
                                                <option>7</option>
                                                <option>8</option>
                                                <option>9</option>
                                                <option>10</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label>Iris Count</label>
                                            <select id="Icount">
                                                <option>0</option>
                                                <option>1</option>
                                                <option>2</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div>
                                        <div>
                                            <label>Face Count</label>
                                            <select id="Pcount">
                                                <option>0</option>
                                                <option>1</option>
                                            </select>
                                        </div>
                                        <div >
                                            <label>Finger Type</label>
                                            <select id="Ftype">
                                                <option value="0">FMR</option>
                                                <option value="1">FIR</option>
                                                <option value="2">BOTH</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>

                                        <div>
                                            <label>Iris Type </label>
                                            <select id="Itype">
                                                <option>SELECT</option>
                                                <option>ISO</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label>Face Type</label>
                                            <select id="Ptype">
                                                <option>SELECT</option>
                                            </select>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div >
                <div>
                    <div>
                        AVDM / Device Info
                    </div>
                    <div>

                        <div>
                            <textarea rows="5" id="txtDeviceInfo"></textarea>
                        </div>


                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <div>
                <div>
                    <div>
                        Pid Options
                    </div>
                    <div>

                        <div>
                            <textarea id="txtPidOptions" rows="5"></textarea>
                        </div>


                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <div >
                <div>
                    <div>
                        Pid Data
                    </div>
                    <div>

                        <div>
                            <textarea id="txtPidData" rows="7"></textarea>
                        </div>


                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <div>
                <div>
                    <div >
                        PERSONAL IDENTITY(PI)
                    </div>
                    <div>
                        <div>

                            <div>
                                <div>

                                    <div>
                                        <label>Name</label>
                                        <div>
                                            <input type="text"  id="txtName" placeholder="Enter Your Name">
                                        </div>
                                    </div>
                                    <div>
                                        <label>Local Name:</label>
                                        <div>
                                            <input type="text"  id="txtLocalNamePI" placeholder="Local Name">
                                        </div>
                                    </div>
                                    <div>
                                        <label>Gender</label>
                                        <div>
                                            <select id="drpGender">
                                                <option value="0">Select</option>
                                                <option>MALE</option>
                                                <option>FEMALE</option>
                                                <option>TRANSGENDER</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div >
                                        <label>DOB</label>
                                        <div>
                                            <input type="text"  id="txtDOB" placeholder="DOB">
                                        </div>
                                    </div>
                                    <div>
                                        <label >Phone</label>
                                        <div >
                                            <input type="text"  id="txtPhone" placeholder="Phone">
                                        </div>
                                    </div>
                                    <div>
                                        <label >DOB Type:</label>
                                        <div >
                                            <select id="drpDOBType" >
                                                <option value="0">select</option>
                                                <option>V</option>
                                                <option>D</option>
                                                <option>A</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div >
                                <div role="form">
                                    <div>
                                        <label >Match Strategy</label>
                                        <div >

                                            <label >
                                                <input type="radio" name="RDPI" id="rdExactPI" checked="true">Exact
                                            </label>
                                            <label >
                                                <input type="radio" name="RDPI" id="rdPartialPI"> Partial
                                            </label>
                                            <label>
                                                <input type="radio" name="RDPI" id="rdFuzzyPI"> Fuzzy
                                            </label>

                                        </div>
                                    </div>
                                    <div>
                                        <label>Match Value:</label>
                                        <div>
                                            <select id="drpMatchValuePI"></select>
                                        </div>
                                    </div>
                                    <div>
                                        <label>Age</label>
                                        <div>
                                            <input type="number"  id="txtAge" placeholder="Age">
                                        </div>
                                    </div>
                                    <div>
                                        <label>LocalMatchValue:</label>
                                        <div>
                                            <select  id="drpLocalMatchValuePI"></select>
                                        </div>
                                    </div>
                                    <div>
                                        <label >Email</label>
                                        <div>
                                            <input type="email"  id="txtEmail" placeholder="Email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div   ">
                <div >
                    <div>
                        PERSONAL ADDRESS(PA)
                    </div>
                    <div>
                        <div >
                            <div >
                                <form role="form" >
                                    <div >
                                        <label >Care Of:</label>
                                        <div >
                                            <input type="text"  id="txtCareOf" placeholder="Care Of:">
                                        </div>
                                    </div>
                                    <div >
                                        <label >Landmark:</label>
                                        <div >
                                            <input type="text"  id="txtLandMark" placeholder="Landmark">
                                        </div>
                                    </div>
                                    <div >
                                        <label >Locality:</label>
                                        <div >
                                            <input type="text"  id="txtLocality" placeholder="Locality">
                                        </div>
                                    </div>
                                    <div >
                                        <label >City:</label>
                                        <div>
                                            <input type="text"  id="txtCity" placeholder="Email">
                                        </div>
                                    </div>
                                    <div >
                                        <label >District:</label>
                                        <div >
                                            <input type="text"  id="txtDist" placeholder="Email">
                                        </div>
                                    </div>
                                    <div >
                                        <label >PinCode:</label>
                                        <div >
                                            <input type="text"  id="txtPinCode" placeholder="PinCode">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div >
                                <form role="form" >
                                    <div >
                                        <label>Building: 	</label>
                                        <div>
                                            <input type="text"  id="txtBuilding" placeholder="Building">
                                        </div>
                                    </div>
                                    <div >
                                        <label >Street:</label>
                                        <div >
                                            <input type="text"  id="txtStreet" placeholder="Street">
                                        </div>
                                    </div>
                                    <div >
                                        <label >PO Name: </label>
                                        <div>
                                            <input type="text"  id="txtPOName" placeholder="PO Name">
                                        </div>
                                    </div>
                                    <div >
                                        <label >Sub Dist:</label>
                                        <div >
                                            <input type="text"  id="txtSubDist" placeholder="Sub Dist">
                                        </div>
                                    </div>
                                    <div >
                                        <label >State:</label>
                                        <div >
                                            <input type="text"  id="txtState" placeholder="State">
                                        </div>
                                    </div>
                                    <div >
                                        <label >Match Strategy:</label>
                                        <div >
                                            <label >
                                                <input type="radio" name="optionsRadiosInline" id="rdMatchStrategyPA" checked="true" value="option1">Exact
                                            </label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div >
                <div >
                    <div>
                        PERSONAL FULL ADDRESS(PFA)
                    </div>
                    <div >
                        <div >
                            <div>
                                <form role="form">
                                    <div >
                                        <label>Email </label>
                                        <label >
                                            <input type="radio" name="RD" id="rdExactPFA" checked="true">Exact
                                        </label>
                                        <label ">
                                            <input type="radio" name="RD" id="rdPartialPFA"> Partial
                                        </label>
                                        <label >
                                            <input type="radio" name="RD" id="rdFuzzyPFA"> Fuzzy
                                        </label>
                                    </div>
                                    <div >
                                        <div >
                                            <div >
                                                <label>Match Value:</label>
                                                <select  id="drpMatchValuePFA"></select>
                                            </div>
                                        </div>
                                        <div >
                                            <div>
                                                <label>Local Match Value:</label>
                                                <select  id="drpLocalMatchValue"></select>
                                            </div>
                                        </div>

                                    </div>

                                </form>
                            </div>
                            <div >
                                <form role="form">
                                    <div >
                                        <label>Address Value:</label>
                                        <textarea rows="2" id="txtAddressValue" ></textarea>
                                    </div>
                                </form>
                            </div>
                            <div >
                                <form role="form">
                                    <div>
                                        <label>Local Address:</label>
                                        <textarea rows="2" id="txtLocalAddress"></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div >
                <label id="lblstatus">
                </label>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<script language="javascript" type="text/javascript">

    var GetCustomDomName='127.0.0.1';
    var GetPIString='';
    var GetPAString='';
    var GetPFAString='';
    var DemoFinalString='';
    var select = '';
    select += '<option val=0>Select</option>';
    for (i=1;i<=100;i++){
        select += '<option val=' + i + '>' + i + '</option>';
    }
    $('#drpMatchValuePI').html(select);
    $('#drpMatchValuePFA').html(select);
    $('#drpLocalMatchValue').html(select);
    $('#drpLocalMatchValuePI').html(select);

    var finalUrl="";
    var MethodInfo="";
    var MethodCapture="";
    var OldPort=false;






    function test()
    {
        alert("I am calling..");
    }

    function reset()
    {
      
    

    
        $('#txtWadh').val('');
        $('#txtDeviceInfo').val('');
        $('#txtPidOptions').val('');
        $('#txtPidData').val('');
        $("select#ddlAVDM").prop('selectedIndex', 0);
        $("select#Timeout").prop('selectedIndex', 0);
        $("select#Icount").prop('selectedIndex', 0);
        $("select#Fcount").prop('selectedIndex', 0);
        $("select#Icount").prop('selectedIndex', 0);
        $("select#Itype").prop('selectedIndex', 0);
        $("select#Ptype").prop('selectedIndex', 0);
        $("select#Ftype").prop('selectedIndex', 0);
        $("select#Dtype").prop('selectedIndex', 0);

        $('#txtotp').val('');
        $("select#pTimeout").prop('selectedIndex', 1);
        $("select#pgCount").prop('selectedIndex', 1);
        $('#txtSSLDomName').val('');
    }
    // All New Function

    function Demo()
    {


    var GetPIStringstr='';
    var GetPAStringstr='';
    var GetPFAStringstr='';

        if(GetPI()==true)
        {
            GetPIStringstr ='<Pi '+GetPIString+' />';

        }
        else
        {
            GetPIString='';
        }

        if(GetPA()==true)
        {
            GetPAStringstr ='<Pa '+GetPAString+' />';
            //alert(GetPAStringstr);
        }
        else
        {
            GetPAString='';
        }

        if(GetPFA()==true)
        {
            GetPFAStringstr ='<Pfa '+GetPFAString+' />';
            //alert(GetPFAStringstr);
        }
        else
        {
            GetPFAString='';
        }

        if(GetPI()==false && GetPA()==false && GetPFA()==false)
        {
            //alert("Fill Data!");
            DemoFinalString='';
        }
        else
        {
            DemoFinalString = '<Demo>'+ GetPIStringstr +' ' + GetPAStringstr + ' ' + GetPFAStringstr + ' </Demo>';
            //alert(DemoFinalString)
        }


    }

    function GetPI()
    {
        var Flag=false;
        GetPIString='';

         if ($("#txtName").val().length > 0)
        {
            Flag = true;
            GetPIString += "name="+ "\""+$("#txtName").val()+"\"";
        }

        if ($("#drpMatchValuePI").val() > 0 && Flag)
        {
            Flag = true;
            GetPIString += " mv="+ "\""+$("#drpMatchValuePI").val()+"\"";
        }

        if ($('#rdExactPI').is(':checked') && Flag)
        {
            Flag = true;
            GetPIString += " ms="+ "\"E\"";
        }
        else if ($('#rdPartialPI').is(':checked') && Flag)
        {
            Flag = true;
           GetPIString += " ms="+ "\"P\"";
        }
        else if ($('#rdFuzzyPI').is(':checked') && Flag)
        {
            Flag = true;
            GetPIString += " ms="+ "\"F\"";
        }
        if ($("#txtLocalNamePI").val().length > 0)
        {
            Flag = true;
            GetPIString += " lname="+ "\""+$("#txtLocalNamePI").val()+"\"";
        }

        if ($("#txtLocalNamePI").val().length > 0 && $("#drpLocalMatchValuePI").val() > 0)
        {
            Flag = true;
            GetPIString += " lmv="+ "\""+$("#drpLocalMatchValuePI").val()+"\"";
        }



            if ($("#drpGender").val() == "MALE")
            {
                Flag = true;
                 GetPIString += " gender="+ "\"M\"";
            }
            else if ($("#drpGender").val() == "FEMALE")
            {
                Flag = true;
                 GetPIString += " gender="+ "\"F\"";
            }
            else if ($("#drpGender").val() == "TRANSGENDER")
            {
                Flag = true;
               GetPIString += " gender="+ "\"T\"";
            }
        //}
            if ($("#txtDOB").val().length > 0 )
            {
                Flag = true;
                GetPIString += " dob="+ "\""+$("#txtDOB").val()+"\"";
            }

            if ($("#drpDOBType").val() != "0")
            {
                Flag = true;
                GetPIString += " dobt="+ "\""+$("#drpDOBType").val()+"\"";
            }

            if ($("#txtAge").val().length)
            {
                Flag = true;
                GetPIString += " age="+ "\""+$("#txtAge").val()+"\"";
            }

            if ($("#txtPhone").val().length > 0 || $("#txtEmail").val().length > 0)
            {
                Flag = true;
                GetPIString += " phone="+ "\""+$("#txtPhone").val()+"\"";
            }
            if ($("#txtEmail").val().length > 0)
            {
                Flag = true;
                GetPIString += " email="+ "\""+$("#txtEmail").val()+"\"";
            }

        //alert(GetPIString);
        return Flag;
    }


    function GetPA()
    {
        var Flag=false;
        GetPAString='';

        if ($("#txtCareOf").val().length > 0)
        {
            Flag = true;
            GetPAString += "co="+ "\""+$("#txtCareOf").val()+"\"";
        }
        if ($("#txtLandMark").val().length > 0 )
        {
            Flag = true;
            GetPAString += " lm="+ "\""+$("#txtLandMark").val()+"\"";
        }
        if ($("#txtLocality").val().length > 0 )
        {
           Flag = true;
            GetPAString += " loc="+ "\""+$("#txtLocality").val()+"\"";
        }
        if ($("#txtCity").val().length > 0 )
        {
            Flag = true;
            GetPAString += " vtc="+ "\""+$("#txtCity").val()+"\"";
        }
        if ($("#txtDist").val().length > 0 )
        {
            Flag = true;
            GetPAString += " dist="+ "\""+$("#txtDist").val()+"\"";
        }
        if ($("#txtPinCode").val().length > 0 )
        {
            Flag = true;
            GetPAString += " pc="+ "\""+$("#txtPinCode").val()+"\"";
        }
        if ($("#txtBuilding").val().length > 0 )
        {
             Flag = true;
            GetPAString += " house="+ "\""+$("#txtBuilding").val()+"\"";
        }
        if ($("#txtStreet").val().length > 0 )
        {
             Flag = true;
            GetPAString += " street="+ "\""+$("#txtStreet").val()+"\"";
        }
        if ($("#txtPOName").val().length > 0 )
        {
             Flag = true;
            GetPAString += " po="+ "\""+$("#txtPOName").val()+"\"";
        }
        if ($("#txtSubDist").val().length > 0 )
        {
              Flag = true;
            GetPAString += " subdist="+ "\""+$("#txtSubDist").val()+"\"";
        }
        if ($("#txtState").val().length > 0)
        {
             Flag = true;
            GetPAString += " state="+ "\""+$("#txtState").val()+"\"";
        }
        if ( $('#rdMatchStrategyPA').is(':checked') && Flag)
        {
            Flag = true;
            GetPAString += " ms="+ "\"E\"";
        }
        //alert(GetPIString);
        return Flag;
    }



    function GetPFA()
    {
        var Flag=false;
        GetPFAString='';

        if ($("#txtAddressValue").val().length > 0)
        {
            Flag = true;
            GetPFAString += "av="+ "\""+$("#txtAddressValue").val()+"\"";
        }

        if ($("#drpMatchValuePFA").val() > 0 && $("#txtAddressValue").val().length > 0)
        {
            Flag = true;
            GetPFAString += " mv="+ "\""+$("#drpMatchValuePFA").val()+"\"";
        }

        if ($('#rdExactPFA').is(':checked') && Flag)
        {
            Flag = true;
            GetPFAString += " ms="+ "\"E\"";
        }
        else if ($('#rdPartialPFA').is(':checked') && Flag)
        {
            Flag = true;
           GetPFAString += " ms="+ "\"P\"";
        }
        else if ($('#rdFuzzyPFA').is(':checked') && Flag)
        {
            Flag = true;
            GetPFAString += " ms="+ "\"F\"";
        }

        if ($("#txtLocalAddress").val().length > 0)
        {
            Flag = true;
            GetPFAString += " lav="+ "\""+$("#txtLocalAddress").val()+"\"";
        }

        if ($("#drpLocalMatchValue").val() > 0 && $("#txtLocalAddress").val().length > 0)
        {
            Flag = true;
            GetPFAString += " lmv="+ "\""+$("#drpLocalMatchValue").val()+"\"";
        }
        //alert(GetPIString);
        return Flag;
    }

    $( "#ddlAVDM" ).change(function() {
    //alert($("#ddlAVDM").val());
    discoverAvdmFirstNode($("#ddlAVDM").val());
    });


    $( "#chkHttpsPort" ).change(function() {
        if($("#chkHttpsPort").prop('checked')==true)
        {
            OldPort=true;
        }
        else
        {
            OldPort=false;
        }

    });

    function discoverAvdmFirstNode(PortNo)
    {

        $('#txtWadh').val('');
        $('#txtDeviceInfo').val('');
        $('#txtPidOptions').val('');
        $('#txtPidData').val('');

    //alert(PortNo);

    var primaryUrl = "http://"+GetCustomDomName+":";
        url = "";
                 var verb = "RDSERVICE";
                    var err = "";
                    var res;
                    $.support.cors = true;
                    var httpStaus = false;
                    var jsonstr="";
                     var data = new Object();
                     var obj = new Object();

                        $.ajax({
                        type: "RDSERVICE",
                        async: false,
                        crossDomain: true,
                        url: primaryUrl + PortNo,
                        contentType: "text/xml; charset=utf-8",
                        processData: false,
                        cache: false,
                        async:false,
                        crossDomain:true,
                        success: function (data) {
                            httpStaus = true;
                            res = { httpStaus: httpStaus, data: data };
                            //alert(data);

                            //debugger;

                             $("#txtDeviceInfo").val(data);

                            var $doc = $.parseXML(data);

                            //alert($($doc).find('Interface').eq(1).attr('path'));


                            if($($doc).find('Interface').eq(0).attr('path')=="/rd/capture")

                            {
                              MethodCapture=$($doc).find('Interface').eq(0).attr('path');
                            }
                            if($($doc).find('Interface').eq(1).attr('path')=="/rd/capture")

                            {
                              MethodCapture=$($doc).find('Interface').eq(1).attr('path');
                            }

                            if($($doc).find('Interface').eq(0).attr('path')=="/rd/info")

                            {
                              MethodInfo=$($doc).find('Interface').eq(0).attr('path');
                            }
                            if($($doc).find('Interface').eq(1).attr('path')=="/rd/info")

                            {
                              MethodInfo=$($doc).find('Interface').eq(1).attr('path');
                            }

                            

                             alert("RDSERVICE Discover Successfully");
                        },
                        error: function (jqXHR, ajaxOptions, thrownError) {
                        $('#txtDeviceInfo').val("");
                        //alert(thrownError);
                            res = { httpStaus: httpStaus, err: getHttpError(jqXHR) };
                        },
                    });

                    return res;
    }








//     async function discoverAvdm() {
//     // Set the custom domain name
//     let GetCustomDomName = "127.0.0.1";
//     if ($("#txtSSLDomName").val().trim().length > 0) {
//         GetCustomDomName = $("#txtSSLDomName").val().trim();
//     }

//     openNav();
//     $('#txtWadh, #txtDeviceInfo, #txtPidOptions, #txtPidData').val('');
//     $("#ddlAVDM").empty();

//     const protocol = window.location.protocol.includes("https") ? "https://" : "http://";
//     const primaryUrl = `${protocol}${GetCustomDomName}:`;
//     let SuccessFlag = 0;

//     for (let i = 11100; i <= 11105; i++) {
//         const port = i === 11105 && OldPort ? "8005" : i.toString();
//         $("#lblStatus1").text(`Discovering RD service on port: ${port}`);

//         try {
//             const url = `${primaryUrl}${port}`;
//             const response = await fetch(url, { method: "RDSERVICE" });

//             if (response.ok) {
//                 const data = await response.text();
//                 $("#txtDeviceInfo").val(data);

//                 const parser = new DOMParser();
//                 const xmlDoc = parser.parseFromString(data, "text/xml");

//                 const status = xmlDoc.querySelector("RDService").getAttribute("status");
//                 const info = xmlDoc.querySelector("RDService").getAttribute("info");

//                 if (info.includes("Mantra")) {
//                     closeNav();

//                     const interfaces = xmlDoc.querySelectorAll("Interface");
//                     interfaces.forEach((iface) => {
//                         const path = iface.getAttribute("path");
//                         if (path === "/rd/capture") MethodCapture = path;
//                         if (path === "/rd/info") MethodInfo = path;
//                     });

//                     $("#ddlAVDM").append(
//                         `<option value="${port}">(${status} - ${port}) ${info}</option>`
//                     );
//                     SuccessFlag = 1;
//                     break; // Stop loop after success
//                 }
//             }
//         } catch (error) {
//             console.error(`Error discovering RD service on port ${port}:`, error);
//         }
//     }

//     // if (SuccessFlag === 0) {
//     //     alert("Connection failed. Please try again.");
//     // } else {
//     //     alert("RDService discovered successfully.");
//     // }

//     $("select#ddlAVDM").prop("selectedIndex", 0);
//     closeNav();
// }

async function discoverAvdm() {
    const getCustomDomName = $("#txtSSLDomName").val().trim() || "127.0.0.1";
    const isHttps = window.location.protocol === "https:";
    const primaryUrl = `${isHttps ? "https" : "http"}://${getCustomDomName}:`;

    // Reset UI
    openNav();
    $('#txtWadh, #txtDeviceInfo, #txtPidOptions, #txtPidData').val('');
    $("#ddlAVDM").empty();
    $("#lblStatus1").text("Discovering RD service...");

    const ports = [11100, 11101, 11102, 11103, 11104, 11105];
    const results = await Promise.allSettled(ports.map(port => checkPort(primaryUrl, port)));

    const validPorts = results
        .filter(result => result.status === "fulfilled" && result.value.success)
        .map(result => result.value);

    if (validPorts.length === 0) {
        alert("Connection failed. Please try again.");
    } else {
        validPorts.forEach(({ port, data, info, status }) => {
            $("#ddlAVDM").append(
                `<option value="${port}">(${status}-${port}) ${info}</option>`
            );
        });
        alert("RDSERVICE discovered successfully.");
        $("#ddlAVDM").prop('selectedIndex', 0);
    }

    closeNav();
}

// Function to check a specific port
async function checkPort(primaryUrl, port) {
    const url = `${primaryUrl}${port}`;
    try {
        const response = await $.ajax({
            type: "RDSERVICE",
            url,
            contentType: "text/xml; charset=utf-8",
            crossDomain: true,
            processData: false,
            cache: false
        });

        const xmlDoc = $.parseXML(response);
        const status = $(xmlDoc).find('RDService').attr('status');
        const info = $(xmlDoc).find('RDService').attr('info');
        const isMantra = info.includes("Mantra");

        if (isMantra) {
            const interfaces = $(xmlDoc).find('Interface');
            interfaces.each((_, iface) => {
                const path = $(iface).attr('path');
                if (path === "/rd/capture") MethodCapture = path;
                if (path === "/rd/info") MethodInfo = path;
            });
            return { success: true, port, data: response, info, status };
        }
    } catch (error) {
        // Handle port failure silently
    }
    return { success: false };
}



    function openNav() {
        document.getElementById("myNav").style.width = "100%";
    }

    function closeNav() {
        document.getElementById("myNav").style.width = "0%";
    }

    function deviceInfoAvdm()
    {
        //alert($("#ddlAVDM").val());
     






        url = "";

                
                // $("#lblStatus").text("Discovering RD Service on Port : " + i.toString());
                //Dynamic URL

                    finalUrl = "http://"+GetCustomDomName+":" + $("#ddlAVDM").val();

                    try {
                        var protocol = window.location.href;
                        if (protocol.indexOf("https") >= 0) {
                            finalUrl = "https://"+GetCustomDomName+":" + $("#ddlAVDM").val();
                        }
                    } catch (e)
                    { }

                //
                 var verb = "DEVICEINFO";
                  //alert(finalUrl);

                    var err = "";

                    var res;
                    $.support.cors = true;
                    var httpStaus = false;
                    var jsonstr="";
                    ;
                        $.ajax({

                        type: "DEVICEINFO",
                        async: false,
                        crossDomain: true,
                        url: finalUrl+MethodInfo,
                        contentType: "text/xml; charset=utf-8",
                        processData: false,
                        success: function (data) {
                        //alert(data);
                            httpStaus = true;
                            res = { httpStaus: httpStaus, data: data };

                            $('#txtDeviceInfo').val(data);
                        },
                        error: function (jqXHR, ajaxOptions, thrownError) {
                        alert(thrownError);
                            res = { httpStaus: httpStaus, err: getHttpError(jqXHR) };
                        },
                    });

                    return res;

    }



    function CaptureAvdm() {
var strWadh = "";
var strOtp = "";
Demo();

if ($("#txtWadh").val() != "") {
    strWadh = ' wadh="' + $("#txtWadh").val() + '"';
}
if ($("#txtotp").val() != "") {
    strOtp = ' otp="' + $("#txtotp").val() + '"';
}


var fType = 2; // Ensure fType is explicitly defined if not from #Ftype
var XML = '<?xml version="1.0"?>' +
    '<PidOptions ver="1.0">' +
    '<Opts ' +
        'fCount="' + $("#Fcount").val() + '" ' +
        'fType="' + (fType) + '" ' + // Use fType variable if explicitly set
        'iCount="' + $("#Icount").val() + '" ' +
        'pCount="' + $("#Pcount").val() + '" ' +
        'pgCount="' + $("#pgCount").val() + '" ' +
        strOtp + // Ensure strOtp is a valid string or empty
        'format="' + $("#Dtype").val() + '" ' +
        'pidVer="' + $("#Pidver").val() + '" ' +
        'timeout="' + $("#Timeout").val() + '" ' +
        'pTimeout="' + $("#pTimeout").val() + '" ' +
        strWadh + // Ensure strWadh is a valid string or empty
        'posh="UNKNOWN" ' +
        'env="' + $("#Env").val() + '" />' +
    DemoFinalString + // Ensure DemoFinalString is valid XML-compatible content
    '<CustOpts>' +
        '<Param name="mantrakey" value="' + $("#txtCK").val() + '" />' +
    '</CustOpts>' +
    '</PidOptions>';

var finalUrl = "http://" + GetCustomDomName + ":" + $("#ddlAVDM").val();

try {
    var protocol = window.location.href;
    if (protocol.indexOf("https") >= 0) {
        finalUrl = "https://" + GetCustomDomName + ":" + $("#ddlAVDM").val();
    }
} catch (e) { }

var verb = "CAPTURE";
var httpStaus = false;

$.support.cors = true;

$.ajax({
    type: "CAPTURE",
    async: false,
    crossDomain: true,
    url: finalUrl + MethodCapture,
    data: XML,
    contentType: "text/xml; charset=utf-8",
    processData: false,
    success: function (data) {
        httpStaus = true;

        $('#txtPidData').val(data);
        $('#txtPidOptions').val(XML);

        // Parse the response XML to JSON
        var jsonStr = xmlToJson($.parseXML(data));
        var formattedJson = JSON.stringify(jsonStr, null, 4);

        // Display the JSON response in a textarea
        $('#txtJsonResponse').val(formattedJson);

        // Extract biometric data
        var biometricData = extractBiometricData(jsonStr);

        // Display extracted biometric data in a textarea
        var formattedBiometricData = JSON.stringify(biometricData, null, 4);
        $('#txtBiometricData').val(formattedBiometricData);

        // Display success message
        var message = $($.parseXML(data)).find('Resp').attr('errInfo');
        alert(message);
    },
    error: function (jqXHR, ajaxOptions, thrownError) {
        alert(thrownError);
    },
});
}

// Utility function to extract biometric data from JSON
function extractBiometricData(response) {
const biometricData = {
    dc: response?.PidData?.DeviceInfo?.["@attributes"]?.dc || "",
    ci: response?.PidData?.Skey?.["@attributes"]?.ci || "",
    hmac: response?.PidData?.Hmac?.["#text"] || "",
    dpId: response?.PidData?.DeviceInfo?.["@attributes"]?.dpId || "",
    mc: response?.PidData?.DeviceInfo?.["@attributes"]?.mc || "",
    pidDataType: response?.PidData?.Data?.["@attributes"]?.type || "",
    sessionKey: response?.PidData?.Skey?.["#text"] || "",
    mi: response?.PidData?.DeviceInfo?.["@attributes"]?.mi || "",
    rdsId: response?.PidData?.DeviceInfo?.["@attributes"]?.rdsId || "",
    errCode: response?.PidData?.Resp?.["@attributes"]?.errCode || "0",
    errInfo: response?.PidData?.Resp?.["@attributes"]?.errInfo || "",
    fCount: response?.PidData?.Resp?.["@attributes"]?.fCount || "1",
    fType: response?.PidData?.Resp?.["@attributes"]?.fType || "2",
    // fType:  "2",
    iCount: response?.PidData?.Resp?.["@attributes"]?.iCount || "1",
    iType: response?.PidData?.Resp?.["@attributes"]?.iType || "",
    // pCount: response?.PidData?.Resp?.["@attributes"]?.pCount || "0",
    pCount:'0',
    pType: response?.PidData?.Resp?.["@attributes"]?.pType || "",
    srno: response?.PidData?.DeviceInfo?.additional_info?.Param?.find(param => param["@attributes"]?.name === "srno")?.["@attributes"]?.value || "",
    sysid: response?.PidData?.DeviceInfo?.additional_info?.Param?.find(param => param["@attributes"]?.name === "sysid")?.["@attributes"]?.value || "",
    ts: response?.PidData?.DeviceInfo?.additional_info?.Param?.find(param => param["@attributes"]?.name === "ts")?.["@attributes"]?.value || "",
    pidData: response?.PidData?.Data?.["#text"] || "",
    qScore: response?.PidData?.Resp?.["@attributes"]?.qScore || "",
    nmPoints: response?.PidData?.Resp?.["@attributes"]?.nmPoints || "",
    rdsVer: response?.PidData?.DeviceInfo?.["@attributes"]?.rdsVer || ""
};

return biometricData;
}

// Utility function to convert XML to JSON
function xmlToJson(xml) {
var obj = {};
if (xml.nodeType === 1) { // element
    if (xml.attributes.length > 0) {
        obj["@attributes"] = {};
        for (var j = 0; j < xml.attributes.length; j++) {
            var attribute = xml.attributes.item(j);
            obj["@attributes"][attribute.nodeName] = attribute.nodeValue;
        }
    }
} else if (xml.nodeType === 3) { // text
    obj = xml.nodeValue;
}

if (xml.hasChildNodes()) {
    for (var i = 0; i < xml.childNodes.length; i++) {
        var item = xml.childNodes.item(i);
        var nodeName = item.nodeName;
        if (typeof (obj[nodeName]) === "undefined") {
            obj[nodeName] = xmlToJson(item);
        } else {
            if (typeof (obj[nodeName].push) === "undefined") {
                var old = obj[nodeName];
                obj[nodeName] = [];
                obj[nodeName].push(old);
            }
            obj[nodeName].push(xmlToJson(item));
        }
    }
}
return obj;
}


    function getHttpError(jqXHR) {
        var err = "Unhandled Exception";
        if (jqXHR.status === 0) {
            err = 'Service Unavailable';
        } else if (jqXHR.status == 404) {
            err = 'Requested page not found';
        } else if (jqXHR.status == 500) {
            err = 'Internal Server Error';
        } else if (thrownError === 'parsererror') {
            err = 'Requested JSON parse failed';
        } else if (thrownError === 'timeout') {
            err = 'Time out error';
        } else if (thrownError === 'abort') {
            err = 'Ajax request aborted';
        } else {
            err = 'Unhandled Error';
        }
        return err;
    }

</script>


</section>  
</div>
<script type="text/javascript" src="jquery-1.12.4.js"></script>


	
        <script>
			var count=0;
            var pidOp="";
			var URL_IP="";
			var vers="Version 3.4";
			var rdSer="L1";
			var LastrdSer="";
			var urlToAll="";
			var comMode="https";
			var LastcomMode="";
			var defaultIP="localhost";
			var servIP="";
			var portNo="11100";
			var first;
			var portNumber ;
			var portNumberStart;
			var portNumberEnd;
			var RDflag = false;
			var IPURL="";
			var scheme;
			var selIP;
			var pidSelected=1;
			var comSel=1;
			var RDServiceName="Morpho_RD_Service";
			var defaultpidOpt='<PidOptions ver=\"1.0\">'+'<Opts env=\"P\" fCount=\"1\" fType=\"0\" iCount=\"\" iType=\"\" pCount=\"\" pType=\"\" format=\"0\" pidVer=\"2.0\" timeout=\"10000\" otp=\"\" wadh=\"\" posh=\"\"/>'+'</PidOptions>';
			
			function initPage() {
            	document.getElementById("pageVersion").innerHTML = vers;
				document.getElementById("AVDM").value = "N.A."; 
				document.getElementById("pidTxt").value = defaultpidOpt;
				//selectDualComMode(document.getElementById("comModeSel1"));
				selectPid(document.getElementById("option1"));
				//showHideDualModeComs(false);
				selIP = defaultIP;
				initRD();
				//temp();
            }
			
			function initRD() {
				updatePortRange();
				//scheme = document.getElementById("comMode").value;
				//document.getElementById("status1").innerHTML = scheme+" "+RDflag;
				if (LastcomMode!=scheme || LastrdSer!=rdSer)
				{
					RDflag = false;
					//document.getElementById("ControlButtons").style.display = "none";
					//document.getElementById("SearchingLbl").style.display = "none";
					//document.getElementById("btnSearch").style.display = "block";
					//Reset();
					//ClearResp();
					document.getElementById("btn2").disabled = true; document.getElementById('btn2').className = 'btn-dis'; 
					document.getElementById("btn3").disabled = true; document.getElementById('btn3').className = 'btn-dis';
					document.getElementById("btn4").disabled = true; document.getElementById('btn4').className = 'btn-dis';
					document.getElementById("btn5").disabled = true; document.getElementById('btn5').className = 'btn-dis';
				}
				else if (LastcomMode==scheme || LastrdSer==rdSer)
				{
					RDflag = true;
					document.getElementById("btn2").disabled = false; document.getElementById('btn2').className = 'btn'; 
					document.getElementById("btn3").disabled = false; document.getElementById('btn3').className = 'btn'; 
					document.getElementById("btn4").disabled = false; document.getElementById('btn4').className = 'btn'; 
					document.getElementById("btn5").disabled = false; document.getElementById('btn5').className = 'btn'; 
				}
            }
			
			function selectDualComMode(radioSelect) {
				if ( radioSelect.value == "1" )
				{
					comSel = 1;					
				}
				else
				{
					comSel = 2;
				}
				initRD();
			}
			
			function selectPid(radioSelect) {
				if ( radioSelect.value == "1" )
				{
					pidSelected = 1;
					//alert("1");
					document.getElementById("pidTxt").disabled = true;
					
					document.getElementById("Timeout").disabled = false;
					//document.getElementById("PiDVer").disabled = false;
					document.getElementById("Format").disabled = false;
					document.getElementById("Posh").disabled = false;
					document.getElementById("otp").disabled = false;
					document.getElementById("Wadh").disabled = false;
					document.getElementById("FingerType").disabled = false;
					document.getElementById("FingerCount").disabled = false;
					document.getElementById("Envir").disabled = false;
				}
				else
				{
					pidSelected = 2;
					//alert("2");
					//alert(document.getElementById("pidTxt").value);
					document.getElementById("pidTxt").disabled = false;
					
					document.getElementById("Timeout").disabled = true;
					//document.getElementById("PiDVer").disabled = true;
					document.getElementById("Format").disabled = true;
					document.getElementById("Posh").disabled = true;
					document.getElementById("otp").disabled = true;
					document.getElementById("Wadh").disabled = true;
					document.getElementById("FingerType").disabled = true;
					document.getElementById("FingerCount").disabled = true;
					document.getElementById("Envir").disabled = true;
				}
			}
			
			function OK_RD() {
				RDflag = true;
				LastcomMode = scheme;
				LastrdSer = rdSer;
				document.getElementById("btn2").disabled = false; document.getElementById('btn2').className = 'btn'; 
				document.getElementById("btn3").disabled = false; document.getElementById('btn3').className = 'btn'; 
				document.getElementById("btn4").disabled = false; document.getElementById('btn4').className = 'btn'; 
				document.getElementById("btn5").disabled = false; document.getElementById('btn5').className = 'btn'; 
				document.getElementById("AVDM").value = RDServiceName + " Running on Port:" + portNumber;
				document.getElementById("status1").innerHTML = RDServiceName + " Found";
				//document.getElementById("SearchingLbl").style.display = "none";
				//document.getElementById("ControlButtons").style.display = "block";
				//style="display: flex; justify-content: center; align-items: center;
			}
			
			function sleep(ms) {
            	return new Promise(resolve => setTimeout(resolve, ms));
            }
			
			function getPosition(string, subString, index) {
				return string.split(subString, index).join(subString).length;
			}
			
			function showHideDualModeComs(dualFlag) {
				if (dualFlag) {
					document.getElementById("comModeSel1").style.visibility		= "visible";
					document.getElementById("lblcomModeSel1").style.visibility	= "visible";
					document.getElementById("comModeSel2").style.visibility		= "visible";
					document.getElementById("lblcomModeSel2").style.visibility	= "visible";
					//document.getElementById("comModeSel1").style.display = "block";
					//document.getElementById("lblcomModeSel1").style.display = "block";
					//document.getElementById("comModeSel2").style.display = "block";
					//document.getElementById("lblcomModeSel2").style.display = "block";
					
				} else {
					document.getElementById("comModeSel1").style.visibility		= "hidden";
					document.getElementById("lblcomModeSel1").style.visibility	= "hidden";
					document.getElementById("comModeSel2").style.visibility		= "hidden";
					document.getElementById("lblcomModeSel2").style.visibility	= "hidden";
					//document.getElementById("comModeSel1").style.display = "none";
					//document.getElementById("lblcomModeSel1").style.display = "none";
					//document.getElementById("comModeSel2").style.display = "none";
					//document.getElementById("lblcomModeSel2").style.display = "none";
				}
			}
			
			function head() {
				scheme = document.getElementById("comMode").value;
				/*if (scheme == "dm") {
					showHideDualModeComs(true);
					
					if (comSel == 1) {
						scheme = "httpdm";
					} else {
						scheme = "httpsdm";
					}
					
				}  else {
					showHideDualModeComs(false);
				}*/
				if (scheme == "httpdm") {
					first = "http";
					portNumber = 11100;
					portNumberStart = 11100;
					portNumberEnd = 11110;
				} else if (scheme == "httpsdm") {
					first = "https";
					portNumber =11111;
					portNumberStart = 11111;
					portNumberEnd = 11120;
				} else if (scheme == "httpsmm") {
					first = "https";
					if (selIP == "localhost") {
						portNumber =11100;
						portNumberStart = 11100;
						portNumberEnd = 11110;
					} else {
						portNumber =11111;
						portNumberStart = 11111;
						portNumberEnd = 11120;
					}					
				} else {
					first = scheme;
					portNumber = 11100;
					portNumberStart = 11100;
					portNumberEnd = 11120;
				}
				RDflag = true;
			}
			
			function SelectRD() {
				rdSer = document.getElementById("rdSelect").value;
				initRD();
				//document.getElementById("pageVersion").innerHTML = rdSer;
			}
			
			function initIP() {
				selIP = document.getElementById("IP").value;
				initRD();
			}
			
			function updatePortRange() {
				head();
				document.getElementById("PortRange").value = portNumberStart+" - "+portNumberEnd;
			} 
			
			function checkRDPort() {
				if(!RDflag){
				   head();
				}
				//document.getElementById("PortNum").value = portNumber;
				//document.getElementById("SearchingLbl").innerHTML = "Searching RD Service at Port number - "+portNumber+"... Please Wait...";
				document.getElementById("status1").innerHTML = "Searching RD Service... Please Wait...";
				
            	//document.getElementById("ControlButtons").style.display = "none";
				//document.getElementById("SearchingLbl").style.display = "block";
				//document.getElementById("btnSearch").style.display = "none";
				
				//var com = document.getElementById("comMode").value;
				var IPurl = document.getElementById("IP").value;
				//var PortNum = document.getElementById("PortNum").value;
				var PortNum = portNumber;
				//var url = com + '://' + IPurl + ':' + PortNum;
				var url = first + '://' + IPurl + ':' + PortNum;
				console.log("URL : " + url);
				//alert(url);
				//return;
				
				var xhr;
				var ua = window.navigator.userAgent;
				var msie = ua.indexOf("MSIE ");
            
            	if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) // If Internet Explorer, return version number
            	{
            		//IE browser
            		xhr = new ActiveXObject("Microsoft.XMLHTTP");
            	} else {
            		//other browser
            		xhr = new XMLHttpRequest();
            	}
            		
            	xhr.open('RDSERVICE', url, true);
				
				xhr.onreadystatechange = function () {
					// if(xhr.readyState == 1 && count == 0){
					//	fakeCall();
					//}
					if (xhr.readyState == 4){
						var status = xhr.status;
						var data = xhr.responseText;
			
						if (status == 200 && ((data.includes("Morpho_RD_Service") && rdSer == "L0S") || (data.includes("MORPHO_RD_SERVICE") && rdSer == "L0H") || (data.includes("IDEMIA_L1_RDSERVICE") && rdSer == "L1")) ){
							if (data.includes("Morpho_RD_Service") && rdSer == "L0S"){			
								RDServiceName = "Morpho_RD_Service";
							} else if (data.includes("MORPHO_RD_SERVICE") && rdSer == "L0H"){
								RDServiceName = "MORPHO_RD_SERVICE";
							} else if (data.includes("IDEMIA_L1_RDSERVICE") && rdSer == "L1"){
								RDServiceName = "IDEMIA_L1_RDSERVICE";
							}
							//alert(xhr.responseText);
							urlToAll = url;							
							console.log(xhr.response);
							OK_RD();
							displayResponse(xhr.response, 1);
			
						} else if (portNumber >= portNumberStart && portNumber < portNumberEnd) {
							console.log(xhr.response);
							portNumber = portNumber + 1;
						
							setTimeout(function() {
								checkRDPort()
							}, 1000);
							// alert(portNumber);
						} else {
							portNumber = 11100;
							RDflag = false;
							alert('!!! Please check the selected RD service is running/installed on the system !!! '+ xhr.response);
							//document.getElementById("SearchingLbl").innerHTML = "Please check, whether RD service is running or not on the system and try again";
							document.getElementById("status1").innerHTML = "Selected RD Service not found";
							document.getElementById("DeviceInfo").innerHTML = "!!! Please check !!! Whether selected RD service is running/installed on the system.";
							RDServiceName = "NO_RD_SERVICE";
							console.log(xhr.response);
						}
					}            
            	};
            
            	xhr.send();
            }
            
		
			
            function displayResponse(resp, reqType) {
            	/*if(resp.includes("Morpho_RD_Service")){
					document.getElementById("status1").innerHTML = "RDSERVICE FOUND";
				}
				else{
					document.getElementById("status1").innerHTML = "RDSERVICE NOT FOUND";
				}*/
            	
            	var parser, xmlDoc;
            	/*var text = '<PidData><Resp errCode="720" errInfo="Device not ready" fCount="11" fType="22" iCount="33" pCount="44" pgCount="55" pTimeout="66" nmPoints="77" qScore="88"/><DeviceInfo dpId="111" rdsId="222" rdsVer="333" dc="444" mi="555" mc="666"><additional_info><Param name="srno" value="aaa"/></additional_info></DeviceInfo><Skey ci="bbb"></Skey><Hmac>CCC</Hmac><Data type="ddd"></Data></PidData>';*/
            
            	//alert(xhr.response);
            	//alert(xhr.responseText);
				
				parser = new DOMParser();
            	xmlDoc = parser.parseFromString(resp,"application/xml");
            	var respText = "", alertMsg = "";
            	const errorNode = xmlDoc.querySelector("parsererror");
            	if (errorNode) {
            	  console.log("error while parsing");
            	  //document.getElementById("demo").innerHTML = "Error";
            	  respText = "Error";
				  alertMsg = "Error";
            	} else {
            	  
            	  var last_tag;
            	  let ctr = 0;
            	  const nodeList = xmlDoc.getElementsByTagName("*")
				  //document.getElementById("demo").innerHTML = "nodeList.length  = "+nodeList.length;
            	  for (var tg2, i = 0, n = nodeList.length; i < n; i++){
            		//let tg2 = nodeList[i].nodeName;
            		let tg2 = nodeList.item(i).nodeName;
            		//document.write(tg2 + "</br>");
            		respText += (tg2 + "</br>");
					alertMsg += tg2 + "\n";
            		if ( tg2 == last_tag ) {
            		  ctr++;
            		}
            		else {
            		  ctr = 0;
            		}
            		var el = xmlDoc.getElementsByTagName(tg2)[ctr];
            		//var nodes=[], values=[];
            		for (var att, j = 0, atts = el.attributes, nn = atts.length; j < nn; j++){
            		  att = atts[j];
            		  //nodes.push(att.nodeName);
            		  //values.push(att.nodeValue);
            		  //document.write(att.nodeName + " = " + att.nodeValue + "</br>");
            		  respText += (att.nodeName + " = " + att.nodeValue + "</br>");
					  alertMsg += (att.nodeName + " = " + att.nodeValue + "\n");
            		}
					
					var nd = el.childNodes[0];
            		//if ( nn==0 && (el.children.length > 0) && (el.childNodes[0].nodeValue!=null) && (el.childNodes[0].nodeValue!="") ) {
					if (nd && nd.nodeValue) { 
            		  //document.write(el.childNodes[0].nodeValue + "</br>");
            		  respText += (el.childNodes[0].nodeValue + "</br>");
					  alertMsg += (el.childNodes[0].nodeValue + "\n");
            		}
            		//document.write("</br>");
            		respText += "</br>";
					alertMsg += "\n";
            		last_tag = tg2;    
            	  }
            	}
				
				if ( reqType == 1 ) {
					document.getElementById("DeviceInfo").innerHTML = respText;
					document.getElementById("status1").innerHTML = "Showing RD Service Status";
					document.getElementById("status2").innerHTML = "";
					document.getElementById("status3").innerHTML = "";
				}
				else if ( reqType == 2 ) {
					document.getElementById("DeviceInfo").innerHTML = respText;
					document.getElementById("status1").innerHTML = "Showing Device Info";
					document.getElementById("status2").innerHTML = "";
					document.getElementById("status3").innerHTML = "";
				}
				else if ( reqType == 3 ) {					
					//document.getElementById("PidOption").value = pidOp;
					document.getElementById("PidData").innerHTML = respText;
					document.getElementById("status1").innerHTML = "";
					document.getElementById("status2").innerHTML = "";
					document.getElementById("status3").innerHTML = "Capture complete";
				}
				else if ( reqType == 0 ) {
					document.getElementById("PidOption").innerHTML = respText;
					//document.getElementById("PidOption").value = respText;
				}
				//alert(alertMsg);
            }
              
            async function RDService() {
				if(!RDflag){
				   checkRDPort();
				   return;
				}
				document.getElementById("DeviceInfo").innerHTML = "";
				document.getElementById("status1").innerHTML = "";
				//var url = "http://127.0.0.1:11100";
				//URL_IP = url;
				//document.getElementById("URL").value = URL_IP;
				//var com = document.getElementById("comMode").value;
				//var IPurl = document.getElementById("IP").value;
				//var PortNum = document.getElementById("PortNum").value;
				//var url = com + '://' + IPurl + ':' + PortNum;
				var url = urlToAll;
				console.log("URL : " + url);
				//alert("RD running URL : " + url);
				//return;
				
				var xhr;
				var ua = window.navigator.userAgent;
				var msie = ua.indexOf("MSIE ");
            
            	if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) // If Internet Explorer, return version number
            	{
            		//IE browser
            		xhr = new ActiveXObject("Microsoft.XMLHTTP");
            	} else {
            		//other browser
            		xhr = new XMLHttpRequest();
            	}
            		
            	xhr.open('RDSERVICE', url, true);
				
				xhr.onreadystatechange = function () {
					// if(xhr.readyState == 1 && count == 0){
					//	fakeCall();
					//}
					if (xhr.readyState == 4){
						var status = xhr.status;
			
						if (status == 200) {
							//alert(xhr.responseText);
							//urlToAll = url;							
							console.log("OK " + xhr.response);
							//RDflag = false;			
						} 
						else {							
							console.log(xhr.response);
							//return;
						}
					}            
            	};
            
            	//RDflag = false; 
				/*setTimeout(function(){
            	 xhr.send();},1000);*/
            	document.getElementById("status1").innerHTML = "Requesting RD Service Status...Wait..";
				document.getElementById("status2").innerHTML = "";
            	document.getElementById("status3").innerHTML = "";	

            	xhr.send();
            	 
            	//await sleep(1000); 
            	var text = "";
            	//text = xhr.response;
            	while ( text==null || text=="" ) {
            		await sleep(1000); 
            		text = xhr.response;
            	}
				
				displayResponse(text, 1);
				//document.getElementById("status1").innerHTML = scheme+" "+RDflag;
				//return 0;
            }
			
			async function DeviceInfo() {				
				document.getElementById("DeviceInfo").innerHTML = "";
				document.getElementById("status1").innerHTML = "";
				//var url = "http://127.0.0.1:11100/getDeviceInfo";
				//URL_IP = url;
				//document.getElementById("URL").value = URL_IP;
				//var url = document.getElementById("URL").value;
				//var com = document.getElementById("comMode").value;
				//var IPurl = document.getElementById("IP").value;
				//var PortNum = document.getElementById("PortNum").value;
				var devOpt = document.getElementById("DevInfo").value;
				//var url = com + '://' + IPurl + ':' + PortNum + "/" + devOpt;
				var url = urlToAll + "/" + devOpt;
				//alert(url);
            
				var xhr;
				var ua = window.navigator.userAgent;
				var msie = ua.indexOf("MSIE ");
	
				if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) // If Internet Explorer, return version number
				{
					//IE browser
					xhr = new ActiveXObject("Microsoft.XMLHTTP");
				} else {
					//other browser
					xhr = new XMLHttpRequest();
				}
            		
				//
				xhr.open('DEVICEINFO', url, true);
				
				xhr.onreadystatechange = function () {
					// if(xhr.readyState == 1 && count == 0){
					//	fakeCall();
					//}
					if (xhr.readyState == 4){
						var status = xhr.status;
			
						if (status == 200) {
			
							//alert(xhr.responseText);									 
							console.log("OK " + xhr.response);
			
						} else 
						{							
							console.log(xhr.response);			
						}
					}
		
				};
            
				document.getElementById("status1").innerHTML = "Requesting Device Info...Please Wait...";
            	document.getElementById("status2").innerHTML = "";
				document.getElementById("status3").innerHTML = "";	

            	xhr.send();
            
            	var text = "";
            	while ( text==null || text=="" ) {
            		await sleep(1000); 
            		text = xhr.response;
            	}
				
				displayResponse(text, 2);
            }
            
            var ver="", fCount="", fType="", iCount="", iType="", pCount="", pType="", format="", pidVer="", timeout="", otp="", wadh="", posh="", url_ip="", env="";
			
			
			async function Capture() {
				
				document.getElementById("PidData").innerHTML = "";
				document.getElementById("status3").innerHTML = "";
				document.getElementById("PidOption").innerHTML = "";
				document.getElementById("status2").innerHTML = "";
            
            	//var url = "http://127.0.0.1:11100/capture";
				//URL_IP = url;
				//document.getElementById("URL").value = URL_IP;
				//var url = document.getElementById("URL").value;
				//var com = document.getElementById("comMode").value;
				//var IPurl = document.getElementById("IP").value;
				//var PortNum = document.getElementById("PortNum").value;
				var capOpt = document.getElementById("Capture").value;
				//var url = com + '://' + IPurl + ':' + PortNum + "/" + capOpt;
				var url = urlToAll + "/" + capOpt;
				//alert(url);
            
            	ver = document.getElementById("Ver").value;
				fCount = document.getElementById("FingerCount").value;
				fType = document.getElementById("FingerType").value;
				format = document.getElementById("Format").value;
				pidVer = document.getElementById("PiDVer").value;
				timeout = document.getElementById("Timeout").value;
				otp = document.getElementById("otp").value;
				wadh = document.getElementById("Wadh").value;
				posh = document.getElementById("Posh").value;
				//iCount = document.getElementById("IrisCount").value;
				//iType = document.getElementById("IrirType").value;
				//pCount = document.getElementById("FaceCount").value;
				//pType = document.getElementById("FaceType").value;
				env = document.getElementById("Envir").value;
				
				var PIDOPTS;
				if ( pidSelected == 1 ) 
				{
					//var PIDOPTS='<PidOptions ver=\"1.0\">'+'<Opts fCount=\"1\" fType=\"0\" iCount=\"\" iType=\"\" pCount=\"\" pType=\"\" format=\"0\" pidVer=\"2.0\" timeout=\"10000\" otp=\"\" wadh=\"\" posh=\"\"/>'+'</PidOptions>';			//L0S-Capture
					
					//PIDOPTS = '<PidOptions ver=\"' + ver + '\">'+'<Opts fCount=\"'+fCount+'\" fType=\"'+fType+'\" iCount=\"'+iCount+'\" iType=\"'+iType+'\" pCount=\"'+pCount+'\" pType=\"'+pType+'\" format=\"'+format+'\" pidVer=\"'+pidVer+'\" timeout=\"'+timeout+'\" otp=\"'+otp+'\" wadh=\"'+wadh+'\" posh=\"'+posh+'\"/>'+'</PidOptions>';
					PIDOPTS = '<PidOptions ver=\"' + ver + '\">'+'<Opts env=\"'+env+'\" fCount=\"'+fCount+'\" fType=\"'+fType+'\" format=\"'+format+'\" pidVer=\"'+pidVer+'\" timeout=\"'+timeout+'\" otp=\"'+otp+'\" wadh=\"'+wadh+'\" posh=\"'+posh+'\"/>'+'</PidOptions>';
				}
				else
				{
					PIDOPTS = document.getElementById("pidTxt").value;
				}
				//alert(PIDOPTS);
				//return;

				//displayResponse(PIDOPTIONS, 1);				
				
				/*var PIDOPTS='<PidOptions ver=\"1.0\">'+'<Opts fCount=\"1\" fType=\"0\" iCount=\"\" iType=\"\" pCount=\"\" pType=\"\" format=\"0\" pidVer=\"2.0\" timeout=\"10000\" otp=\"\" wadh=\"\" posh=\"\"/>'+'</PidOptions>';*/
				
				pidOp = PIDOPTS;
				//document.getElementById("PidOption").value = pidOp;				
				displayResponse(pidOp, 0);
            	/*
            	format=\"0\"     --> XML
            	format=\"1\"     --> Protobuf
            	*/
            	var xhr;
            	var ua = window.navigator.userAgent;
            	var msie = ua.indexOf("MSIE ");
            
            	if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) // If Internet Explorer, return version number
            	{
            		//IE browser
            		xhr = new ActiveXObject("Microsoft.XMLHTTP");
            	} else {
            		//other browser
            		xhr = new XMLHttpRequest();
            	}
            		
				xhr.open('CAPTURE', url, true);
				xhr.setRequestHeader("Content-Type","text/xml");
				xhr.setRequestHeader("Accept","text/xml");
		
				xhr.onreadystatechange = function () {
					//if(xhr.readyState == 1 && count == 0){
					//	fakeCall();
					//}
					if (xhr.readyState == 4){
						var status = xhr.status;
						//parser = new DOMParser();
						if (status == 200) {
							var errChk = 0;
							if ( rdSer == "L0S" ) 
							{
								errChk = 2;
							}
							else
								errChk = 4;
								
							var test1=xhr.responseText;
							var test2=test1.search("errCode");
							var test6=getPosition(test1, '"', errChk);
							var test4=test2+9;
							var test5=test1.slice(test4, test6);
							//alert(xhr.responseText);
							if (test5>0)
							{
								//alert(first + " Capture Unsuccessful errorCode = " + test2 + " " + test6 + " " + test4 + " " + test5);
								alert("XXX Capture Unsuccessful XXX");
							}
							else
							{
								//alert(first + " Capture Successful errorCode = " + test2 + " " + test6 + " " + test4 + " " + test5);
								alert("--- Capture Successful ---");
							}
							const xmlData=xhr.response;

							const xml = xhr.response; // Your entire XML string here

// Parse XML
const parser = new DOMParser();
const xmlDoc = parser.parseFromString(xml, "text/xml");

// Extract values
const getAttr = (tag, attr) => xmlDoc.getElementsByTagName(tag)[0]?.getAttribute(attr) || '';
const getParamValue = (name) => {
  const params = xmlDoc.getElementsByTagName("Param");
  for (let param of params) {
    if (param.getAttribute("name") === name) {
      return param.getAttribute("value");
    }
  }
  return '';
};

// Output values
const result = {
  dc: getAttr("DeviceInfo", "dc"),
  ci: getAttr("Skey", "ci"),
  hmac: xmlDoc.getElementsByTagName("Hmac")[0]?.textContent || '',
  dpId: getAttr("DeviceInfo", "dpId"),
  mc: getAttr("DeviceInfo", "mc"),
  pidDataType: getAttr("Data", "type"),
  sessionKey: xmlDoc.getElementsByTagName("Skey")[0]?.textContent || '',
  mi: getAttr("DeviceInfo", "mi"),
  rdsId: getAttr("DeviceInfo", "rdsId"),
  errCode: getAttr("Resp", "errCode"),
  errInfo: getAttr("Resp", "errInfo"),
  fCount: getAttr("Resp", "fCount"),
  fType: 2,
  iCount: getAttr("Resp", "iCount"),
  iType: getAttr("Resp", "iType"),
  pCount: getAttr("Resp", "pCount"),
  pType: getAttr("Resp", "pType"),
  srno: getParamValue("srno"),
  sysid: getParamValue("serial_number"),
  ts: new Date().toISOString(), // Current timestamp
  pidData: xmlDoc.getElementsByTagName("Data")[0]?.textContent || '',
  qScore: 80,
  nmPoints: getAttr("Resp", "nmPoints"),
  rdsVer: getAttr("DeviceInfo", "rdsVer")
};

//    var biometricData = extractBiometricData(jsonStr);

//         // Display extracted biometric data in a textarea
//         var formattedBiometricData =result;
//         $('#txtBiometricData').val(formattedBiometricData);
console.log(result);
 document.getElementById("txtBiometricData").value = JSON.stringify(result, null, 4);

							//console.log(xmlData);
						} else 
						{						
							console.log(xhr.response);
						}
					}
		
				};
				
				document.getElementById("status1").innerHTML = "";
				document.getElementById("status2").innerHTML = "Sending Options...Please Wait...";
            	document.getElementById("status3").innerHTML = "Capturing...Please Wait...";				
            	
				xhr.send(PIDOPTS);
				
				var text = "";
            	while ( text==null || text=="" ) {
            		await sleep(1000); 
            		text = xhr.responseText;
					//alert(xhr.responseText);
					//alert(text);
            	}	
            	
				displayResponse(text, 3);
            }
			
        </script>
		
    </head>
    <body onload="initPage()">
		
		
		    <button type="button" class="btn" id="btn1" onclick="RDService()"  style="display:none">RD Service</button>
            		<button type="button" class="btn" id="btn3" onclick="Capture()" style="display:none">Capture</button>
			<button type="button" class="btn" id="btn2" onclick="DeviceInfo()" style="display:none" >Device Info</button>
	
			<button type="button" class="btn" id="btn4" onclick="Reset()" style="display:none"  style="margin: 0px 10px 0px 50px;">Reset Options</button>
			<button type="button" class="btn" id="btn5" onclick="ClearResp()" style="display:none" >Clear Response</button>
		
			<div style="display: none;">
			<input type="text" hidden name="rdSelect" id="rdSelect"  value="L1">
			<input type="text" hidden name="comMode" id="comMode" value="https">
			<input type="text" hidden name="IP" id="IP" value="localhost">	
			<input type="text" hidden name="PortRange" id="PortRange" value="00000 - 00000" disabled>
			<input type="text" hidden name="DevInfo" id="DevInfo" value="getDeviceInfo">	
			<input type="text" hidden name="Capture" id="Capture" value="capture">	
				
				
			<p id="ControlButtons" class="btn-panel">
			
		
				
				<div class="pidOpts">
				
				<input type="hidden" id="option1" name="PidOpt" value="1" style="display: inline; float: left; margin: 50px 0px 0px 5px; height:15px; width:15px;" onclick="selectPid(this);" checked="checked">
				
				<div class="pidOpt1" id="PidOpt1">
				
					
					<input type="text" hidden name="AVDM" id="AVDM" style="padding: 2px 0px 0px 5px; width: 275px;" value="XXXXXX_RD_Service" disabled>
				
					<input type="text" hidden name="FingerCount" id="FingerCount" style="padding: 2px 0px 0px 5px; width: 80px;" value="1">
				
					<input type="text" hidden name="FingerType" id="FingerType" style="padding: 2px 0px 0px 5px; width: 80px;" value="0">
				
					<input type="text" hidden name="Format" id="Format" style="padding: 2px 0px 0px 5px; width: 80px;" value="0">
					
					<input type="text" hidden name="otp" id="otp" style="padding: 2px 0px 0px 5px; width: 80px;" value="">
					
					<input type="text" hidden name="Posh" id="Posh" style="padding: 2px 0px 0px 5px; width: 80px;" value="">
				 
					<input type="text" hidden name="PTimeout" id="PTimeout" style="padding: 2px 0px 0px 5px; width: 115px;" value="" disabled>
					
					<input type="text" hidden name="PGCount" id="PGCount" style="padding: 2px 0px 0px 5px; width: 115px;" value="" disabled>
					
				
			
					<input type="text" hidden name="Ver" id="Ver" style="padding: 2px 0px 0px 5px; width: 80px;" value="1.0" disabled>
					
					
					<input type="text" hidden name="PiDVer" id="PiDVer" style="padding: 2px 0px 0px 5px; width: 80px;" value="2.0" disabled>
					
					<input type="text" hidden name="Envir" id="Envir" style="padding: 2px 0px 0px 5px; width: 80px;" value="P">
					
					<input type="text" hidden name="Timeout" id="Timeout" style="padding: 2px 0px 0px 5px; width: 80px;" value="10000">
					
				
				
				<textarea name="Wadh" hidden id="Wadh" style="width: 120px; height: 98px; padding: 5px; resize: none;" placeholder="Enter text"></textarea>
				
<!-- 				
				<input type="radio" hidden id="option2" name="PidOpt" value="2" style="display: inline; float: left; margin: 50px 0px 0px 10px; height:15px; width:15px;" onclick="selectPid(this);"> -->
				
				
					<textarea name="pidTxt"  hidden id="pidTxt" class="pidTxt"></textarea>
				
			
			<div id="Panel2" class="panel2-main">
			<div id="Panel2a" class="panel2a">
				
				<p id="status1" style="display: inline; float: right; margin: 4px 4px 0px 0px; font-size: 12px; color:red;"></p>
				<hr>
				<p id="DeviceInfo" class="paras"></p>
			</div>

			<div id="Panel2b" class="panel2b">
				
				<p id="status2" style="display: inline; float: right; margin: 3px 3px 0px 0px; font-size: 12px; color:red;"></p>
			
				<p id="PidOption" class="paras"></p>
				
			
		
			
			<div id="Panel3-main" class="panel3-main">
			<div id="Panel3" class="panel3">
				
				<p id="status3" style="display: inline; float: right; margin: 3px 3px 0px 0px; font-size: 12px; color:red;"></p>
				
				<p id="PidData" class="paras3"></p>
			
		
		
		
			<p id="pageVersion" style="display: inline; font-size: 12px;"></p>
			
		
		</div>
		</div>
    </body>
</html>
