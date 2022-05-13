window.axios = require('axios');
const appDomain = "https://coniq.test";
var create = document.getElementById('create');

create.addEventListener('click', function () {

  let fname = document.getElementById('RegisterForm-FirstName').value;
  let lname = document.getElementById('RegisterForm-LastName').value;
  let reg_email = document.getElementById('RegisterForm-email').value;
  let password = document.getElementById('RegisterForm-password').value;
  let checkbox = document.getElementById('checkbox');
  if(checkbox.checked == true){
     var flag = 1;
     var flag_email = true;
     var flag_sms = true;
  }else{
     var flag = 0;
     var flag_email = false;
     var flag_sms = false;
  }

  axios.post(appDomain + '/api/customerUpdate', {
    fname:fname,
    lname:lname,
    reg_email:reg_email,
    password:password,
    checkbox:flag,
    flag_email:flag_email,
    flag_sms:flag_sms
  }).then(function (response) {
    console.log(response);
  })["catch"](function (error) {
    console.log("ERROR: ", error);
  });
});

