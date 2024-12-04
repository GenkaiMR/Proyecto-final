function validatePassword(password) {
    // Expresión regular que valida los requisitos de la contraseña
    const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{7,}$/;
  
    return passwordPattern.test(password); // Devuelve true si cumple con los requisitos
  }
  