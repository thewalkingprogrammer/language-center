function validateRegistration() {
    var fName = document.forms["frmRegistration"]["firstName"].value;
    var lName = document.forms["frmRegistration"]["lastName"].value;
    var email = document.forms["frmRegistration"]["email"].value;
    var password = document.forms["frmRegistration"]["password1"].value;
    
    if (fName == "" || lName == "" || email == "" || password == "") {
        alert("All fields must be set!");
        return false;
    }
    
    if(document.forms["frmRegistration"]["firstName"].value.length > 30 ||
       document.forms["frmRegistration"]["lastName"].value.length > 30){
        alert('First name and last name cannot be greater than 30');
        return false;
    }
    
    if(document.forms["frmRegistration"]["email"].value.length > 100){
        alert('Email cannot be greater than 100');
        return false;
    }
    
    if(document.forms["frmRegistration"]["password1"].value.length > 20){
        alert('Password cannot be greater than 20');
        return false;
    }
}

function validateEditUser() {
    var fName = document.forms["frmEditUserAdmin"]["firstName"].value;
    var lName = document.forms["frmEditUserAdmin"]["lastName"].value;
    var email = document.forms["frmEditUserAdmin"]["email"].value;
    
    
    if (fName == "" || lName == "" || email == "") {
        alert("All fields must be set!");
        return false;
    }
    
    if(document.forms["frmRegistration"]["firstName"].value.length > 30 ||
       document.forms["frmRegistration"]["lastName"].value.length > 30){
        alert('First name and last name cannot be greater than 30');
        return false;
    }
    
    if(document.forms["frmRegistration"]["email"].value.length > 100){
        alert('Email cannot be greater than 100');
        return false;
    }
}

function validateAddUser() {
    var fName = document.forms["frmAddUser"]["firstName"].value;
    var lName = document.forms["frmAddUser"]["lastName"].value;
    var email = document.forms["frmAddUser"]["email"].value;
    var password = document.forms["frmAddUser"]["password1"].value;
    
    if (fName == "" || lName == "" || email == "" || password == "") {
        alert("All fields must be set!");
        return false;
    }
    
    if(document.forms["frmAddUser"]["firstName"].value.length > 30 ||
       document.forms["frmAddUser"]["lastName"].value.length > 30){
        alert('First name and last name cannot be greater than 30');
        return false;
    }
    
    if(document.forms["frmAddUser"]["email"].value.length > 100){
        alert('Email cannot be greater than 100');
        return false;
    }
    
    if(document.forms["frmAddUser"]["password1"].value.length > 20){
        alert('Password cannot be greater than 20');
        return false;
    }
}

function validateAddLecture() {
    var title = document.forms["frmAddLecture"]["title"].value;
    var body = document.forms["frmAddLecture"]["body"].value;
    
    if (title == "" || body == "") {
        alert("All fields must be set!");
        return false;
    }
    
    if(document.forms["frmAddLecture"]["title"].value.length > 50){
        alert('Title cannot be greater than 50');
        return false;
    }
    
    if(document.forms["frmAddLecture"]["body"].value.length > 3000){
        alert('Body cannot be greater than 3000');
        return false;
    }
}