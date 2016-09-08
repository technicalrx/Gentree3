var childcount=0;
// Enter button will not work when submit form
$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});

// Check Email is valid or not
isValidateEmail = function(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 

// UserFirstname
check_firstname = function() {
    var firstname = $("#user_firstname").val();
    if(firstname!="") {
        $("#user_first_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#user_first_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter First Name");
        return false;
    }
}

// UserLastname
check_lastname = function() {
    var lastname = $("#user_lastname").val();
    if(lastname!="") {
       $("#user_last_error").html(""); 
        return true;
        // console.log("ajax request...");
    } else {
        $("#user_last_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Last Name");
        return false;
    }
}

// UserFirstname


check_zip = function() {
  var zip = $("#user_zip").val();
  var regexzip=/^\d{5}(-\d{4})?$/;
   if(regexzip.test(zip))
   {
       $("#user_zip_error").html("");
        // console.log("ajax request...");
        return true;
   }else
   {
     $("#user_zip").val("");
        $("#user_zip_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Zipcode");
        return false;
   }
}

check_city = function() {
 
    var city = $("#user_city").val();
    if(city!="") {
        
        $("#user_city_error").html("");
        $("#user_state_error").html("");
        $("#user_zip_error").html("");

        return true;
    } else {
      
      $("#user_state").val("");
      $("#user_zip").val("");  
        $("#user_city_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter City");
        $("#user_state_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter State");
        return false;
    }
}

// check password field
function IsPass(pass)
         {
           var re = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{8,}$/;
           return re.test(pass);
         }


function checkEmailInDb()
{
  var email = $("#user_email").val();
  var checkemail=true;
  // Ajax check email is there
              $.ajax({
                type: 'post',
                url: 'ajax_check_email.php?email='+email,
                data: "search="+email,
                success: function (response) 
                 {
                    if(response=='1')
                    {
                       $("#email-error").html("<i class='icon-warning-sign'></i>&nbsp;Email already exists"); 
                       $("#check_email_value").val('0');
                       return true;
                    }
                else
                    { 
                     // alert("error");
                       $("#check_email_value").val('1');
                       return false;
                    } 
                 }
                });
              //return checkemail;
}


check_email_store_in_db = function()
{
  var email_check = $("#check_email_value").val();
  if(email_check=='0')
  {
    return false;
  }else
  {
    return true;
  }
}

// Check email field
check_email = function() {
  checkEmailInDb();
    var username = $("#user_email").val();
    if(isValidateEmail(username)) {
        $("#email-error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#email-error").html("<i class='icon-warning-sign'></i>&nbsp;Invalid email address");
        return false;
    }
}

// check confirm email field
check_cnf_email = function()
{
  checkEmailInDb();
  var cnf_email = $("#cnf-email").val();
  var email = $("#user_email").val();
    if(email==cnf_email) {
        $("#cnf-email-error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#cnf-email-error").html("<i class='icon-warning-sign'></i>&nbsp;It should be same Email Address");
        return false;
    }
}

// check password
check_password = function()
{

    checkEmailInDb();
   var pass=$("#user_password").val();
   if(IsPass(pass)) {
        $("#pass-error").css("display", "none");
        $("#pass-guide").css("display", "block");
        return true;
        // console.log("ajax request...");
    } else {
      $("#pass-guide").css("display", "none");
      $("#pass-error").css("display", "block");
        $("#pass-error").html("<i class='icon-warning-sign'></i>&nbsp;Must contain at least 8 characters and include at least one number and one special character");
      return false;
    }
}


// check confirm passsword
check_cnf_password = function()
{

   var pass=$("#user_password").val();
   var cnf_pass=$("#cnf_password").val();

    if(pass==cnf_pass)
    {
      $("#cnf-pass-error").html("");
      return true;
    }
    else
    {
      $("#cnf-pass-error").html("<i class='icon-warning-sign'></i>&nbsp; Passwords do not match");
      return false;
    } 
        // console.log("ajax request...");
    
}

// child1 validation start
// Check child first name
check_child1_first = function() {
    var firstname = $("#child1_first_name").val();
    if(firstname!="") {
        $("#child1_first_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child1_first_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's First Name");
        return false;
    }
}

// Check child first name
check_child1_last = function() {
    var firstname = $("#child1_last_name").val();
    if(firstname!="") {
        $("#child1_last_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child1_last_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's Last Name");
        return false;
    }
}

// Check child date of birth
check_child1_dob = function() {
    var month = $("#child1_month").val();
    var year = $("#child1_year").val();
    var dob=month+'-'+year;
    if(dob!='1-2016') {
        $("#child1_dob_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child1_dob_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's Date of Birth");
        return false;
    }
}

// Check child gender
check_child1_gender = function() {
    var gender = $('input[name=child1_gender]:checked').length;
    if(gender>0) {
        $("#child1_gender_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child1_gender_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's Gender");
        return false;
    }
}

// Check child picture
check_child1_pic = function() {
    var gender = $("#child1_pic").val();
    if(gender!="") {
        $("#child1_pic_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child1_pic_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's Picture");
        return false;
    }
}
// Child 1 End



// child2 validation start
// Check child first name
check_child2_first= function() {
    var firstname = $("#child2_first_name").val();
    if(firstname!="") {
        $("#child2_first_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child2_first_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's First Name");
        return false;
    }
}

// Check child first name
check_child2_last = function() {
    var firstname = $("#child2_last_name").val();
    if(firstname!="") {
        $("#child2_last_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child2_last_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's Last Name");
        return false;
    }
}

// Check child date of birth
check_child2_dob = function() {
      var month = $("#child2_month").val();
    var year = $("#child2_year").val();
    var dob=month+'-'+year;
    if(dob!='1-2016') {
        $("#child2_dob_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child2_dob_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's Date of Birth");
        return false;
    }
}

// Check child gender
check_child2_gender = function() {
    var gender = $('input[name=child2_gender]:checked').length;
    if(gender>0) {
        $("#child2_gender_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child2_gender_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's Gender");
        return false;
    }
}

// Check child picture
check_child2_pic = function() {
    var gender = $("#child2_pic").val();
    if(gender!="") {
        $("#child2_pic_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child2_pic_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's Picture");
        return false;
    }
}
// Child 2 End

// child3 validation start
// Check child first name
check_child3_first= function() {
    var firstname = $("#child3_first_name").val();
    if(firstname!="") {
        $("#child3_first_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child3_first_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child First Name");
        return false;
    }
}

// Check child first name
check_child3_last = function() {
    var firstname = $("#child3_last_name").val();
    if(firstname!="") {
        $("#child3_last_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child3_last_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's Last Name");
        return false;
    }
}

// Check child date of birth
check_child3_dob = function() {
       var month = $("#child3_month").val();
    var year = $("#child3_year").val();
    var dob=month+'-'+year;
    if(dob!='1-2016') {
        $("#child3_dob_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child3_dob_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's Date of Birth");
        return false;
    }
}

// Check child gender
check_child3_gender = function() {
    var gender = $('input[name=child3_gender]:checked').length;
    if(gender>0) {
        $("#child3_gender_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child3_gender_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's Gender");
        return false;
    }
}

// Check child picture
check_child3_pic = function() {
    var gender = $('#child3_pic').val();
    if(gender!="") {
        $("#child3_pic_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child3_pic_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's Picture");
        return false;
    }
}
// Child 3 End

// child4 validation start
// Check child first name
check_child4_first= function() {
    var firstname = $("#child4_first_name").val();
    if(firstname!="") {
        $("#child4_first_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child4_first_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child First Name");
        return false;
    }
}

// Check child first name
check_child4_last = function() {
    var firstname = $("#child4_last_name").val();
    if(firstname!="") {
        $("#child4_last_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child4_last_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's Last Name");
        return false;
    }
}

// Check child date of birth
check_child4_dob = function() {
      var month = $("#child4_month").val();
    var year = $("#child4_year").val();
    var dob=month+'-'+year;
    if(dob!='1-2016') {
        $("#child4_dob_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child4_dob_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's Date of Birth");
        return false;
    }
}

// Check child gender
check_child4_gender = function() {
    var gender = $('input[name=child4_gender]:checked').length;
    if(gender>0) {
        $("#child4_gender_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child4_gender_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's Gender");
        return false;
    }
}

// Check child picture
check_child4_pic = function() {
    var gender = $("#child4_pic").val();
    if(gender!="") {
        $("#child4_pic_error").html("");
        return true;
        // console.log("ajax request...");
    } else {
        $("#child4_pic_error").html("<i class='icon-warning-sign'></i>&nbsp;Please enter Child's Picture");
        return false;
    }
}

             

// Form submit
function formSignupSubmit()
{
  console.log(checkEmailInDb()+" "+uservalue+" "+check_email_store_in_db());
  var uservalue=(check_firstname() & check_lastname() & check_city() & check_zip() & check_email() & check_email_store_in_db() & check_cnf_email() & check_password() & check_cnf_password() );
      var returnVar=true;
      console.log(checkEmailInDb()+" "+uservalue+" "+check_email_store_in_db());
      if(childcount==0)
      {
        alert("Enter at least one child");
        return false;
      }
      switch(childcount)
      {
          case 1:
          var child1=(check_child1_first() & check_child1_last() &  check_child1_dob() & check_child1_gender() );
         console.log(child1);
            if((!uservalue) || (!child1) )
            {
              returnVar=false;
            }  
          break;

          case 2:
          var child12=(check_child1_first() & check_child1_last() &  check_child1_dob() & check_child1_gender()  & check_child2_first() & check_child2_last() &  check_child2_dob() & check_child2_gender() );
          if(!uservalue || !child12 )
          { 
              returnVar=false;
          }
          break;

          case 3:
          var child123=(check_child1_first() & check_child1_last() &  check_child1_dob() & check_child1_gender()  & check_child2_first() & check_child2_last() &  check_child2_dob() & check_child2_gender() 
            & check_child3_first() & check_child3_last() &  check_child3_dob() & check_child3_gender() );
        
          if(!uservalue || !child123 )
          {
              returnVar=false;
          }
          break;

          case 4:
           var child1234=(check_child1_first() & check_child1_last() &  check_child1_dob() & check_child1_gender()  & check_child2_first() & check_child2_last() &  check_child2_dob() & check_child2_gender() 
            & check_child3_first() & check_child3_last() &  check_child3_dob() & check_child3_gender()  & check_child4_first() & check_child4_last() & check_child4_dob() & check_child4_gender() );
          if(!uservalue || !child1234 )
          {
              returnVar=false;
          }
          break;

          default :
          if(!uservalue )
            returnVar=false;
          break;
      } 

      return returnVar;

}

// Form submit
function formUpdate()
{
  var uservalue=(check_firstname() & check_lastname() & check_city()  & check_password() & check_cnf_password() );
      var returnVar=true;
  
      switch(childcount)
      {
          case 1:
          var child1=(check_child1_first() &  check_child1_dob() & check_child1_gender() );

            if((!uservalue) || (!child1) )
            {
              returnVar=false;
            }  
          break;

          case 2:
          var child12=(check_child1_first() &  check_child1_dob() & check_child1_gender()  & check_child2_first() &  check_child2_dob() & check_child2_gender());
          if(!uservalue || !child12 )
          { 
              returnVar=false;
          }
          break;

          case 3:
          var child123=(check_child1_first() &  check_child1_dob() & check_child1_gender()  & check_child2_first() &  check_child2_dob() & check_child2_gender() 
            & check_child3_first() &  check_child3_dob() & check_child3_gender());
        
          if(!uservalue || !child123 )
          {
              returnVar=false;
          }
          break;

          case 4:
           var child1234=(check_child1_first() &  check_child1_dob() & check_child1_gender()  & check_child2_first() &  check_child2_dob() & check_child2_gender() 
            & check_child3_first() &  check_child3_dob() & check_child3_gender()  & check_child4_first() & check_child4_dob() & check_child4_gender() );
          if(!uservalue || !child1234 )
          {
              returnVar=false;
          }
          break;

          default :
          if(!uservalue )
            returnVar=false;
          break;
      } 

      return returnVar;

}

function formCheckPassword()
{
   var uservalue=(check_password() & check_cnf_password() );
    if(!uservalue )
          {
              return false;
          }else return true;
}