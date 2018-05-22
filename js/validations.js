
// validates a name
function validateName(){
  var name = document.getElementById("name");
  var res = /^[A-Za-zñÑáéíóúÁÉÍÓÚ ]+$/.test(name.value);

  if(!res){
      document.getElementById("name").style.borderColor = "red";
  }else{
    document.getElementById("name").style.borderColor = "#3c3a37";
  }
}

// validates a surname
function validateSurname(){
  var surname = document.getElementById("surname");
  var res = /^[A-Za-zñÑáéíóúÁÉÍÓÚ]+ [A-Za-zñÑáéíóúÁÉÍÓÚ]+$/.test(surname.value);

  if(!res){
      document.getElementById("surname").style.borderColor = "red";
  }else{
    document.getElementById("surname").style.borderColor = "#3c3a37";
  }
}

// validates a dni
function validateDni() {
  var number, let, letter;

  var dni = document.getElementById("dni").value;

  dni = dni.toUpperCase();


    if(/^[XYZ]?\d{5,8}[A-Z]$/.test(dni) === true){
        number = dni.substr(0,dni.length-1);
        number = number.replace('X', 0);
        number = number.replace('Y', 1);
        number = number.replace('Z', 2);
        let = dni.substr(dni.length-1, 1);
        number = number % 23;
        letter = 'TRWAGMYFPDXBNJZSQVHLCKET';
        letter = letter.substring(number, number+1);
        if (letter != let) {
          document.getElementById("dni").style.borderColor = "red";

        }else{
          document.getElementById("dni").style.borderColor = "#3c3a37";

        }
    }else{
      document.getElementById("dni").style.borderColor = "red";

    }
}

// validates a telephone
function validateTelephone(){
  var telephone = document.getElementById("telephone");
  var res = /^[9|6|7][0-9]{8}$/.test(telephone.value);

  if(!res){
      document.getElementById("telephone").style.borderColor = "red";
  }else{
    document.getElementById("telephone").style.borderColor = "#3c3a37";
  }
}

// validates an email
function validateUsername(){
  var username = document.getElementById("username");
  var res = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(username.value);

  if(!res){
      document.getElementById("username").style.borderColor = "red";
  }else{
    document.getElementById("username").style.borderColor = "#3c3a37";
  }
}

// validates a password
function validatePassword(){
  var password = document.getElementById("password");
  var res = /^[A-Za-zñÑáéíóúÁÉÍÓÚ0-9\.]{5,20}$/.test(password.value);

  if(!res){
    document.getElementById("password").style.borderColor = "red";
  }else{
    document.getElementById("password").style.borderColor = "#3c3a37";
  }
}

// validates a password
function validateRepeatPassword(){
  var repeatPassword = document.getElementById("repeatpassword");
  var res = /^[A-Za-zñÑáéíóúÁÉÍÓÚ0-9\.]{5,20}$/.test(repeatPassword.value);

  if(!res){
    document.getElementById("repeatpassword").style.borderColor = "red";
  }else{
    document.getElementById("repeatpassword").style.borderColor = "#3c3a37";
  }
}

// validates a description text
function validateDescription(){
  var description = document.getElementById("description");
  var res = /^[A-Za-z0-9\sáéíóúÁÉÍÓÚñÑ()ºª.:,"'¡!\-\+/]+$/.test(description.value);

  if(!res){
    document.getElementById("description").style.borderColor = "red";
  }else{
    document.getElementById("description").style.borderColor = "#3c3a37";
  }
}


var singleElimination = {
  "teams": [              // Matchups
    ["Team 1", "Team 2"], // First match
    ["Team 3", "Team 4"]  // Second match
  ],
  "results": [            // List of brackets (single elimination, so only one bracket)
    [                     // List of rounds in bracket
      [                   // First round in this bracket
        [1, 2],           // Team 1 vs Team 2
        [3, 4]            // Team 3 vs Team 4
      ],
      [                   // Second (final) round in single elimination bracket
        [5, 6],           // Match for first place
        [7, 8]            // Match for 3rd place
      ]
    ]
  ]
}
$('.t').bracket({
  init:singleElimination
})
