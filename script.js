const form = document.getElementById('formRegistrazione');
const passwordInput = document.getElementById('password');

form.addEventListener('submit', function(event) {
  event.preventDefault();

  const password = passwordInput.value;

  if (password.length < 9) {
    alert('La password deve avere almeno 8 caratteri.');
  }
  else if (!/[A-Z]/.test(password)) {
    alert('La password deve avere almeno 1 carattere maiuscolo.');
   
  }
  else if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
    alert('La password deve avere almeno 1 carattere speciale(!@#$%^&*(),.?)');
  
  }
  else{
  	  form.submit();
  }


});