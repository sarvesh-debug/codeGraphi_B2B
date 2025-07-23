
	
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
  fType: getAttr("Resp", "fType"),
  iCount: getAttr("Resp", "iCount"),
  iType: getAttr("Resp", "iType"),
  pCount: getAttr("Resp", "pCount"),
  pType: getAttr("Resp", "pType"),
  srno: getParamValue("srno"),
  sysid: getParamValue("serial_number"),
  ts: new Date().toISOString(), // Current timestamp
  pidData: xmlDoc.getElementsByTagName("Data")[0]?.textContent || '',
  qScore: getAttr("Resp", "qScore") ,
  nmPoints: getAttr("Resp", "nmPoints"),
  rdsVer: getAttr("DeviceInfo", "rdsVer")
};

console.log(result);
document.getElementById("PidData").innerHTML = respText;

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
		
		
		    <button type="button" class="btn" id="btn1" onclick="RDService()"  >RD Service</button>
            		<button type="button" class="btn" id="btn3" onclick="Capture()" >Capture</button>
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