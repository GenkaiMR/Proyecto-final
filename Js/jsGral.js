
 // SCRIPT PARA REGISTRAR EMPLEADO

$('#registerModal').on('hidden.bs.modal', function () {
  // Reseteamos el formulario de edición
  $('#registerForm')[0].reset();  // Esto resetea el formulario
  $('#registerInfo')[0].reset();  // Esto también resetea los campos de información
});

// Cuando el botón "Register" es presionado
$('#registerInfo').on('submit', function(event) {
  // Evitar que el formulario recargue la página
  event.preventDefault();

  // Obtener las contraseñas
  const paswo = $('#passwordd').val();
  const confirmPas = $('#confirmm').val();
  const email = $('#emaill').val(); // Obtener el correo electrónico
  const username = $('#usernamee').val(); // Obtener el correo electrónico

  // Verificar que el correo tiene una sintaxis válida
  if (!validateEmail(email)) {
    alert('Please enter a valid email.');
    return;
  }

  // Verificar que la contraseña cumple con los requisitos
  if (!validatePassword(paswo)) {
    alert('The password must have at least one uppercase letter, one lowercase letter, one number, and at least 7 characters.');
    return;
  }

  // Verificar que las contraseñas coinciden
  if (paswo !== confirmPas) {
    alert('Passwords do not match. Please try again.');
    return;
  }


  // Verificar si el correo ya existe
  $.ajax({
    url: '../conexion/checkEmail.php', // Ruta al archivo PHP que valida el correo
    type: 'POST',
    data: { email: email },
    dataType: 'json',
    success: function(response) {
      if (response.exists){
        // Si el correo ya está registrado, mostrar un mensaje de error
        alert('The email is already registered. Please use another.');
      } else {
        // Si no está registrado, procede a enviar el formulario
      checkUsername();
      }
    },
    error: function(xhr, status, error) {
      alert('Something went wrong while validating the email. Try again.');
    }
  });


  function checkUsername(){
    // Verificar si el usuario ya existe
    $.ajax({
      url: '../conexion/checkUsername.php', // Ruta al archivo PHP que valida el correo
      type: 'POST',
      data: { username: username },
      dataType: 'json',
      success: function(response) {
        if (response.exists) {
          // Si el usuario ya está registrado, mostrar un mensaje de error
          alert('The username is already registered. Please use another.');
          exit();
        } else {
          // Si no está registrado, procede a enviar el formulario
          registerEmployee();
        }
      },
      error: function(xhr, status, error) {
        alert('Something went wrong while validating the Username. Try again.');
      }
  });
}
});



// Función para registrar al empleado
function registerEmployee() {
  // Obtener los valores de los campos del formulario
  var name = $('#namee').val();
  var surname = $('#surnamee').val();
  var lastname = $('#lastnamee').val();
  var email = $('#emaill').val();
  var position = $('#positionn').val();
  var username = $('#usernamee').val();
  var password = $('#passwordd').val();
  var confirm = $('#confirmm').val();
  var role = $('#rolee').val();

  // Hacer la solicitud AJAX al archivo PHP usando POST
  $.ajax({
    url: '../conexion/registerEmployee.php', // Ruta al archivo PHP que maneja el registro
    type: 'POST',
    data: {
      name: name,           // Nombres
      surname: surname,     // Apellido
      lastname: lastname,   // Segundo apellido
      email: email,         // Correo electrónico
      position: position,   // Puesto
      username: username,   // Nombre de usuario
      password: password,   // Contraseña
      confirm: confirm,     // Confirmación de contraseña
      role: role            // Rol
    },
    dataType: 'json',
    success: function(response) {
      if (response.success) {
        alert('Employee successfully registered');
        $('#registerModal').modal('hide');  // Cerrar el modal si la actualización fue exitosa
        location.reload();  // Recargar la página para ver los cambios
      } else {
        alert('Error: ' + response.error);  // Mostrar el error si hubo algún problema
      }
    },
    error: function(xhr, status, error) {
      alert('Something went wrong while recording the data: ' + error);
    }
  });
}

// Validación de la sintaxis del correo
function validateEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Expresión regular para validar correos
  return emailRegex.test(email);
}


    // <-- SCRIPT PARA EDITAR LA INFORMACIÓN DEL EMPLEADO --> //

// Cuando el botón "Cargar Datos" es presionado
 $('#editForm').on('submit', function(event) {
    // Evitar que el formulario recargue la página
    event.preventDefault();   
  
    var number = $('#number').val();  // Obtener el número de empleado
  
    // Verificar que el número de empleado no esté vacío
    if (number.trim() === '') {
      alert('Please enter an employee number');
      return;
    }else if (!$.isNumeric(number)) {  
      alert("The employee number must be a numeric value");
      return;  // Salimos si el número no es válido
  }

  

  
  
    // Hacer la solicitud AJAX al archivo PHP usando POST
    $.ajax({
      url: '../conexion/getInfoEmp.php',  // Ruta al archivo PHP que devuelve los datos
      type: 'POST',                       // Método POST
      data: { number: number },           // Enviar el número de empleado como parámetro en el cuerpo
      dataType: 'json',                   // Esperamos que la respuesta sea un objeto JSON
      success: function(response) {
        // Si se obtienen datos correctamente
        if (response.error) {
          // Si hay un error, mostrarlo en la consola o en el UI
          alert(response.error);
        } else {
          // Si no hay error, mostrar los datos en los inputs
          $('#name').val(response.name);
          $('#surname').val(response.surname);
          $('#lastname').val(response.lastname);
          $('#email').val(response.email);
          $('#position').val(response.position);
          $('#username').val(response.username);
          $('#role').val(response.role);
        }
      },
      error: function(xhr, status, error) {
        // Si ocurre un error en la solicitud AJAX
        alert('Something went wrong while loading the data: ' + error);
      }
    });
  });
  
  
  $('#editModal').on('hidden.bs.modal', function () {
          // Reseteamos el formulario de edición
          $('#editForm')[0].reset();  // Esto resetea el formulario
          $('#editInfo')[0].reset();  // Esto también resetea los campos de información
      });
  
      
  // Cuando el botón "Save changes" es presionado
  $('#editInfo').on('submit', function(event) {
      // Evitar que el formulario recargue la página
      event.preventDefault();
      
  
      // Obtener los valores de los campos del formulario
      var name = $('#name').val();
      var surname = $('#surname').val();
      var lastname = $('#lastname').val();
      var email = $('#email').val();
      var position = $('#position').val();
      var username = $('#username').val();
      var role = $('#role').val();
      var number = $('#number').val();  // Número de empleado, para identificar al empleado a actualizar
  
      // Verificar que el número de empleado no esté vacío
      if (number.trim() === '') {
          alert('Please enter an employee number');
          return;
      }
  
      // Hacer la solicitud AJAX al archivo PHP usando POST
      $.ajax({
          url: '../conexion/editEmployee.php',  // Ruta al archivo PHP que maneja la actualización
          type: 'POST',            // Método POST
          data: {
              number: number,       // Número de empleado
              name: name,           // Nombre
              surname: surname,     // Apellido
              lastname: lastname,   // Segundo apellido
              email: email,         // Correo electrónico
              position: position,   // Puesto
              username: username,   // Nombre de usuario
              role: role            // Rol
          },
          dataType: 'json',        // Esperamos una respuesta JSON
          success: function(response) {
              if (response.success) {
                  alert('Employee successfully updated');
                  $('#editModal').modal('hide');  // Cerrar el modal si la actualización fue exitosa
                  location.reload();  // Recargar la página para ver los cambios
              } else {
                  alert('Error: ' + response.error);  // Mostrar el error si hubo algún problema
              }
          },
          error: function(xhr, status, error) {
              alert('Something went wrong while updating the data: ' + error);
          }
      });
  });



  // <-- SCRIPT PARA CAMBIAR LA CONTRASEÑA DEL EMPLEADO --> //

  // Cuando el botón "Cargar Datos" es presionado
  $('#changeForm').on('submit', function(event) {
    // Evitar que el formulario recargue la página
    event.preventDefault();   
  
    var username = $('#getUsername').val();  // Obtener el usuario del empleado
  
    // Verificar que el número de empleado no esté vacío
    if (username.trim() === '') {
      alert('Please enter the employee username');
      return;
    }
  
    // Hacer la solicitud AJAX al archivo PHP usando POST
    $.ajax({
      url: '../conexion/getInfoUser.php',  // Ruta al archivo PHP que devuelve los datos
      type: 'POST',                 // Método POST
      data: { getUsername: username },     // Enviar el número de empleado como parámetro en el cuerpo
      dataType: 'json',             // Esperamos que la respuesta sea un objeto JSON
      success: function(response) {
        // Si se obtienen datos correctamente
        if (response.error) {
          // Si hay un error, mostrarlo en la consola o en el UI
          alert(response.error);
        } else {
          // Si no hay error, mostrar los datos en los inputs
          $('#showname').val(response.name);
          $('#showsurname').val(response.surname);
          $('#showlastname').val(response.lastname);
          $('#showusername').val(response.username);
        }
      },
      error: function(xhr, status, error) {
        // Si ocurre un error en la solicitud AJAX
        alert('Something went wrong while loading the data: ' + error);
      }
    });
  });
  
  $('#changePassword').on('hidden.bs.modal', function () {
          // Reseteamos el formulario de edición
          $('#changeForm')[0].reset();  // Esto resetea el formulario
          $('#passForm')[0].reset();  // Esto también resetea los campos de información
  
});
  
  
  // Función para manejar el evento de "Guardar cambios" en el modal de cambio de contraseña
  $('#saveChanges').on('click', function(event) {
    // Evitar que el formulario recargue la página
    event.preventDefault();
  
    // Obtener las contraseñas
    const password = $('#pass').val();
    const confirmPassword = $('#confitmPassword').val();
  
    // Verificar que la contraseña cumple con los requisitos
    if (!validatePassword(password)) {
      alert('The password must have at least one uppercase letter, one lowercase letter, one number, and at least 7 characters.');
      return;
    }
  
    // Verificar que las contraseñas coinciden
    if (password !== confirmPassword) {
      alert('Passwords do not match. Please try again.');
      return;
    }
  
    // Si pasa la validación, entonces hacer la solicitud AJAX para cambiar la contraseña
    var username = $('#getUsername').val();  // Obtener el nombre de usuario
  
    // Verificar que el campo de usuario no esté vacío
    if (username.trim() === '') {
      alert('Please enter a username.');
      return;
    }
  
    
    // Hacer la solicitud AJAX para cambiar la contraseña
    $.ajax({
      url: '../conexion/changePassword.php',  // Ruta al archivo PHP que maneja el cambio de contraseña
      type: 'POST',
      data: {
        showusername: username, // El nombre de usuario
        password: password, // La nueva contraseña
      },
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          alert('Password changed successfully');
          $('#changePassword').modal('hide');  // Cerrar el modal si la contraseña fue cambiada
        } else {
          alert('Error: ' + response.error);  // Mostrar el error si hubo algún problema
        }
      },
      error: function(xhr, status, error) {
        alert('Something went wrong when changing the password: ' + error);
      }
    });
  });

  
  $('#modalStatus').on('hidden.bs.modal', function () {
    // Reseteamos el formulario 
    $('#statusForm')[0].reset();  // Esto resetea el formulario

});






 // Cuando el botón "Cargar Datos" es presionado
 $('#orderForm').on('submit', function(event) {
    // Evitar que el formulario recargue la página
    event.preventDefault();   
  
    var number = $('#Number').val();  // Obtener el número de empleado
  
    // Hacer la solicitud AJAX al archivo PHP usando POST
    $.ajax({
      url: '../conexion/getInfoEmp.php',  // Ruta al archivo PHP que devuelve los datos
      type: 'POST',                 // Método POST
      data: { number: number },     // Enviar el número de empleado como parámetro en el cuerpo
      dataType: 'json',             // Esperamos que la respuesta sea un objeto JSON
      success: function(response) {
        // Si se obtienen datos correctamente
        if (response.error) {
          // Si hay un error, mostrarlo en la consola o en el UI
          alert(response.error);
        } else {
          // Si no hay error, mostrar los datos en los inputs
          $('#name').val(response.name);
          $('#surname').val(response.surname);
          $('#lastname').val(response.lastname);
          $('#email').val(response.email);
          $('#position').val(response.position);
          $('#username').val(response.username);
          $('#role').val(response.role);
        }
      },
      error: function(xhr, status, error) {
        // Si ocurre un error en la solicitud AJAX
        alert('Something went wrong while loading the data: ' + error);
      }
    });
  });


  // OTRO SCRIPT

$(document).ready(function() {
    // Captura el evento click del enlace "Status"
    $('a[data-bs-target="#modalStatus"]').on('click', function(event) {
        event.preventDefault(); // Evita la acción predeterminada del enlace
        
        // Obtén el número de la orden desde el atributo data-id del enlace "Status"
        var orderNumber = $(this).data('id');
        $('#orderNumber').val(orderNumber); 

        // Realiza una solicitud AJAX para obtener las opciones de estado
        $.ajax({
            url: '../conexion/getStatus.php',  // URL para obtener los estados
            type: 'POST',
            data: { Number: orderNumber },  // Enviar el número de la orden
            success: function(response) {
                // Actualiza las opciones del select con la respuesta
                $('#modalStatus select[name="status"]').html(response);
            },
            error: function() {
                alert('Something went wrong while getting the data from the state.');
            }
        });
    });
});


$('#saveStatus').on('click', function(event) {
    event.preventDefault(); // Prevenir el envío del formulario tradicional

    // Recoger los datos a enviar mediante AJAX
    var orderNumber = $('#orderNumber').val();
    var status = $('select[name="status"]').val(); // Obtener el estado seleccionado

    // Enviar los datos usando AJAX
    $.ajax({
        url: '../conexion/editStatusOrder.php',  // El archivo PHP que manejará la solicitud
        type: 'POST',  // Método POST
        data: {
            Numero: orderNumber,  // Enviar el número de orden
            status: status        // Enviar el estado seleccionado
        },
        success: function(response) {
            // Parsear la respuesta JSON del servidor
            var result = JSON.parse(response);

            if (result.success) {
                // Opcionalmente, mostrar un mensaje de éxito
                alert('Status updated successfully!');
                
                // Cerrar el modal (también puedes actualizar el estado directamente en la tabla)
                $('#modalStatus').modal('hide');
                location.reload();  // Recargar la página para ver los cambios
                // Puedes actualizar la tabla o el estado mostrado, si es necesario
                // Si lo deseas, puedes recargar la página o actualizar la tabla dinámicamente
            } else {
                // Mostrar un mensaje de error si algo salió mal
                alert(result.error || 'Something went wrong while updating the status.');
            }
        },
        error: function() {
            // Manejar cualquier error en la solicitud AJAX
            alert('Something went wrong. Please try again.');
        }
    });
});

/* -----------------------------PRODUCTS-------------------------- */



/* --------------------------------SUBMIT PRODUCT------------------------------------- */



$('#saveProduct').on('click', function(event) {
  event.preventDefault(); // Evitar que el formulario recargue la página

  // Obtener el formulario usando su ID
  const formData = new FormData($('#productForm')[0]); // Usamos el formulario correcto

  // Enviar los datos del formulario al servidor con fetch
  fetch('../conexion/createProduct.php', {
    method: 'POST',
    body: formData, // Enviar los datos al servidor
  })
  .then(response => response.json()) // Se espera que la respuesta sea en formato JSON
  .then(data => {
    console.log('Success:', data);
    
    // Si la respuesta del servidor indica éxito
    if (data.success) {
      // Aquí puedes hacer alguna acción como cerrar el modal o limpiar el formulario

      // Opcional: Mostrar un mensaje de éxito o actualizar alguna parte de la interfaz
      alert('Product registered correctly.');
      $('#createProduct').modal('hide');
                location.reload(); 
    } else {
      // Si el servidor devuelve un error
      alert('Error: ' + data.error || 'Something went wrong while registering the product.');
    }
  })
  .catch((error) => {
    console.error('Error:', error);
    alert('Something went wrong while sending the data to the server.');
  });
});

/* ----------------------REGISTER INGREDIENTS------------------------ */
$('#saveIngredient').on('click', function(event) {
  event.preventDefault(); // Evitar que el formulario recargue la página

  // Obtener el formulario usando su ID
  const formData = new FormData($('#ingreForm')[0]); // Usamos el formulario correcto

  // Enviar los datos del formulario al servidor con fetch
  fetch('../conexion/submitIngredient.php', {
    method: 'POST',
    body: formData, // Enviar los datos al servidor
  })
  .then(response => response.json()) // Se espera que la respuesta sea en formato JSON
  .then(data => {
    console.log('Success:', data);
    
    // Si la respuesta del servidor indica éxito
    if (data.success) {
      // Aquí puedes hacer alguna acción como cerrar el modal o limpiar el formulario

      // Opcional: Mostrar un mensaje de éxito o actualizar alguna parte de la interfaz
      alert('Ingredient registered correctly.');
                location.reload(); 
    } else {
      // Si el servidor devuelve un error
      alert('Error: ' + data.error || 'Something went wrong when registering the ingredient.');
    }
  })
  .catch((error) => {
    console.error('Error:', error);
    alert('Something went wrong while sending the data to the server.');
  });
});

/* -----------------------------------Register Active Ingredient----------------------------------- */

$('#saveActive').on('click', function(event) {
  event.preventDefault(); // Evitar que el formulario recargue la página

  // Obtener el formulario usando su ID
  const formData = new FormData($('#activeForm')[0]); // Usamos el formulario correcto

  // Enviar los datos del formulario al servidor con fetch
  fetch('../conexion/submitActIngre.php', {
    method: 'POST',
    body: formData, // Enviar los datos al servidor
  })
  .then(response => response.json()) // Se espera que la respuesta sea en formato JSON
  .then(data => {
    console.log('Success:', data);
    
    // Si la respuesta del servidor indica éxito
    if (data.success) {
      // Aquí puedes hacer alguna acción como cerrar el modal o limpiar el formulario

      // Opcional: Mostrar un mensaje de éxito o actualizar alguna parte de la interfaz
      alert('Active ingredient registered correctly.');
                location.reload(); 
    } else {
      // Si el servidor devuelve un error
      alert('Error: ' + data.error || 'Something went wrong when registering the active ingredient.');
    }
  })
  .catch((error) => {
    console.error('Error:', error);
    alert('Something went wrong while sending the data to the server.');
  });
});

/* ----------------------------------Register Packing Material ------------------------------------- */

$('#savePacking').on('click', function(event) {
  event.preventDefault(); // Evitar que el formulario recargue la página

  // Obtener el formulario usando su ID
  const formData = new FormData($('#packForm')[0]); // Usamos el formulario correcto

  // Enviar los datos del formulario al servidor con fetch
  fetch('../conexion/submitPackMat.php', {
    method: 'POST',
    body: formData, // Enviar los datos al servidor
  })
  .then(response => response.json()) // Se espera que la respuesta sea en formato JSON
  .then(data => {
    console.log('Success:', data);
    
    // Si la respuesta del servidor indica éxito
    if (data.success) {
      // Aquí puedes hacer alguna acción como cerrar el modal o limpiar el formulario

      // Opcional: Mostrar un mensaje de éxito o actualizar alguna parte de la interfaz
      alert('Packaging material registered correctly.');
                location.reload(); 
    } else {
      // Si el servidor devuelve un error
      alert('Error: ' + data.error || 'Something went wrong while checking the packaging material.');
    }
  })
  .catch((error) => {
    console.error('Error:', error);
    alert('Something went wrong while sending the data to the server.');
  });
});

/* ----------------------REGISTER PRESENTATION------------------------ */
$('#savePres').on('click', function(event) {
  event.preventDefault(); // Evitar que el formulario recargue la página

  // Obtener el formulario usando su ID
  const formData = new FormData($('#presentForm')[0]); // Usamos el formulario correcto

  // Enviar los datos del formulario al servidor con fetch
  fetch('../conexion/submitPresentation.php', {
    method: 'POST',
    body: formData, // Enviar los datos al servidor
  })
  .then(response => response.json()) // Se espera que la respuesta sea en formato JSON
  .then(data => {
    console.log('Success:', data);
    
    // Si la respuesta del servidor indica éxito
    if (data.success) {
      // Aquí puedes hacer alguna acción como cerrar el modal o limpiar el formulario

      // Opcional: Mostrar un mensaje de éxito o actualizar alguna parte de la interfaz
      alert('Type of presentation registered correctly.');
                location.reload(); 
    } else {
      // Si el servidor devuelve un error
      alert('Error: ' + data.error || 'Something went wrong when registering the type of presentation.');
    }
  })
  .catch((error) => {
    console.error('Error:', error);
    alert('Something went wrong while sending the data to the server.');
  });
});

/* --------------------------------RESET FORM--------------------------------------- */

$('#createProduct').on('hidden.bs.modal', function () {
  // Reseteamos el formulario
  $('#productForm')[0].reset();  // Esto resetea el formulario

});

$(document).ready(function() {
  $(".btn-add-new-ingre").click(function(event) {
      event.preventDefault(); // Esto evitará que la página se recargue
      // Aquí puedes añadir cualquier acción adicional, como agregar un nuevo ingrediente al formulario
  });
});



/* --------------------------- Customers------------------------------ */


$(document).ready(function() {
  // Cuando el formulario de creación de cliente es enviado
  $('#registerForm').on('submit', function(event) {
      // Evitar que el formulario recargue la página
      event.preventDefault();

      const numTel = $('#numTel').val(); //Obtener el numero de telefono
      const email = $('#email').val(); // Obtener el correo electrónico
      const taxname = $('#taxname').val(); // Obtener el nombre Fiscal


  // Verificar si el nombre Fiscal ya existe
  $.ajax({
    url: '../conexion/checkTaxName.php', // Ruta al archivo PHP que valida el nombre
    type: 'POST',
    data: { taxname: taxname },
    dataType: 'json',
    success: function(response) {
      if (response.exists) {
        // Si el nombre ya está registrado, mostrar un mensaje de error
        alert('The Trade Name is already registered. Please use another.');
      } else {
        // Si no está registrado, procede a enviar el formulario
        checkMail()
      }
    },
    error: function(xhr, status, error) {
      alert('Something went wrong while validating the Username. Try again.');
    }
});

function checkMail(){
        // Verificar si el correo ya existe
  $.ajax({
    url: '../conexion/checkEmail.php', // Ruta al archivo PHP que valida el correo
    type: 'POST',
    data: { email: email },
    dataType: 'json',
    success: function(response) {
      if (response.exists) {
        // Si el correo ya está registrado, mostrar un mensaje de error
        alert('The email is already registered. Please use another.');
      } else {
        // Si no está registrado, procede a enviar el formulario
        checkPhone();

      }
    },
    error: function(xhr, status, error) {
      alert('Something went wrong while validating the email. Try again.');
    }
  });
}

function checkPhone(){
  // Verificar si el correo ya existe
$.ajax({
url: '../conexion/checkPhone.php', // Ruta al archivo PHP que valida el correo
type: 'POST',
data: { numTel: numTel },
dataType: 'json',
success: function(response) {
    if (response.exists) {
      // Si el correo ya está registrado, mostrar un mensaje de error
      alert('The Phone number is already registered. Please use another.');
    } else {
      // Si no está registrado, procede a enviar el formulario
      regCustomer();
    }
    },
    error: function(xhr, status, error) {
    alert('Something went wrong while validating the Phone number. Try again.');
    }
    });
}

});

        // Hacer la solicitud AJAX al archivo PHP que maneja la creación del cliente
  function regCustomer(){ 
          // Obtener los valores de los campos del formulario
          var taxname = $('input[name="taxname"]').val();
          var contactname = $('input[name="contactname"]').val();
          var surname = $('input[name="surname"]').val();
          var lastname = $('input[name="lastname"]').val();
          var email = $('input[name="email"]').val();
          var numTel = $('input[name="numTel"]').val();

        $.ajax({
            url: '../conexion/createCustomer.php', // Ruta al archivo PHP que maneja la creación del cliente
            type: 'POST',
            data: {
                taxname: taxname,         // Nombre legal
                contactname: contactname,     // Nombre de contacto
                surname: surname,         // Primer apellido
                lastname: lastname,         // Segundo apellido
                email: email,                 // Correo electrónico
                numTel: numTel                  // Número de teléfono
            },
            dataType: 'json',  // Esperamos una respuesta JSON
            success: function(response) {
                if (response.success) {
                    // Si la creación fue exitosa, mostrar un mensaje y limpiar el formulario
                    alert('Customer succesfully created!');
                    $('#registerForm')[0].reset();
                    location.reload(); // Resetea el formulario
                } else {
                    // Si hubo un error, mostrar el error
                    alert('Error: ' + response.error);
                }
            },
            error: function(xhr, status, error) {
                // Si ocurre un error en la solicitud AJAX
                alert('Something went wrong when creating the client');
            }
        });
 }
  });

  
///////// JS ACTUALIZAR CLIENTEE

  // Capturamos el evento de submit del formulario de búsqueda
  $('#editarCForm').submit(function(e) {
    e.preventDefault();  // Prevenimos el comportamiento por defecto del formulario

    var customerNumber = $('#number').val().trim();  // Obtenemos el número de cliente y eliminamos espacios

    // Validaciones
    if (customerNumber === "") {
      alert("Please enter a customer number.");
      return;  // Salimos si no se ha ingresado un número de cliente
    } else if (!$.isNumeric(customerNumber)) {  
      alert("The customer number must be a numeric value");
      return;  // Salimos si el número no es válido
    }

    // Realizamos la solicitud AJAX
    $.ajax({
      url: '../conexion/getInfoCus.php',  // Asegúrate de poner la ruta correcta al archivo PHP
      type: 'POST',
      data: { number: customerNumber },  // Enviamos el número de cliente
      dataType: 'json',
      success: function(response) {
        // Depurar: Verificar qué datos devuelve el servidor
        console.log(response); 
        
        if (response.error) {
          // Si hay un error, mostramos el mensaje
          alert(response.error);
        } else {
          // Asegurarnos de abrir el modal y luego asignar los valores
          $('#editCModal').modal('show'); // Abre el modal si no está visible

          // Asignamos los valores a los inputs una vez que el modal esté visible
          $('#showTaxname').val(response.taxname);
          $('#showContactname').val(response.contactname);
          $('#conSurname').val(response.surname);
          $('#conLastname').val(response.lastname);
          $('#conEmail').val(response.email);
          $('#conNumTel').val(response.numTel);
        }
      },
      error: function(xhr, status, error) {
        alert("Something went wrong while processing the request:" + error);
      }
    });
  });






$('#editCModal').on('hidden.bs.modal', function () {
        // Reseteamos el formulario de edición
        $('#editarCForm')[0].reset();  // Esto resetea el formulario
        $('#editCInfo')[0].reset();  // Esto también resetea los campos de información
    });

    
// Cuando el botón "Save changes" es presionado
$('#editCInfo').on('submit', function(event) {
    // Evitar que el formulario recargue la página
    event.preventDefault();

    const numTell = $('#conNumTel').val(); //Obtener el numero de telefono


    // Validación del número de teléfono
    var phoneRegex = /^[0-9]{10}$/;
    if (!phoneRegex.test(numTell)) {
        alert('The phone number must contain exactly 10 numbers.');
        return; // Detener el envío del formulario
    }

    // Obtener los valores de los campos del formulario
    var taxname = $('#showTaxname').val();
    var contactname = $('#showContactname').val();
    var surname = $('#conSurname').val();
    var lastname = $('#conLastname').val();
    var email = $('#conEmail').val();
    var numTel = $('#conNumTel').val();
    var number = $('#number').val();  // Número de empleado, para identificar al empleado a actualizar

    // Verificar que el número de empleado no esté vacío
    // Validaciones
    if (number.trim() === "") {
      alert("Please enter an employee number.");
      return;  // Salimos si no se ha ingresado un número de cliente
    } else if (!$.isNumeric(number)) {  
      alert("The employee number must be a numeric value");
      return;  // Salimos si el número no es válido
    }

    // Hacer la solicitud AJAX al archivo PHP usando POST
    $.ajax({
        url: '../conexion/editCustomer.php',  // Ruta al archivo PHP que maneja la actualización
        type: 'POST',            // Método POST
        data: {
            number: number,           // Número de empleado
            taxname: taxname,         // Nombre
            contactname: contactname, // Nombre de Contacto    
            surname: surname,         // Apellido
            lastname: lastname,       // Segundo apellido
            email: email,             // Correo electrónico
            numTel: numTel            // Número de telefono
        },
        dataType: 'json',        // Esperamos una respuesta JSON
        success: function(response) {
            if (response.success) {
                alert('Employee successfully updated');
                $('#editModal').modal('hide');  // Cerrar el modal si la actualización fue exitosa
                location.reload();  // Recargar la página para ver los cambios
            } else {
                alert('Error: ' + response.error);  // Mostrar el error si hubo algún problema
            }
        },
        error: function(xhr, status, error) {
            alert('Something went wrong while updating the data: ' + error);
        }
    });
});




/* ---------------------------Register Order------------------------------ */


// SCRIPT PARA REGISTRAR PEDIDO

// Reseteo del formulario al cerrar el modal
$('#registerOrderModal').on('hidden.bs.modal', function () {
  // Reseteamos el formulario
  $('#registerOrderInfo')[0].reset();
});

// Cuando el formulario es enviado
$('#registerOrderInfo').on('submit', function (event) {
  // Evitar que el formulario recargue la página
  event.preventDefault();

  // Obtener los valores de los campos del formulario
  var customer = $('#Customer').val();
  var product = $('#Product').val();
  var unitsQty = $('#UnitsQty').val();
  var delivery = $('#Delivery').val();

  // Validar los datos antes de enviarlos
  if (!customer || !product || !unitsQty || !delivery) {
      alert('All fields are required.');
      return; // Detenemos la ejecución si hay campos vacíos
  }

  // Hacer la solicitud AJAX al archivo PHP usando POST
  $.ajax({
      url: '../conexion/submitOrder.php',  // Ruta al archivo PHP que maneja el insert
      type: 'POST',            // Método POST
      data: {
          customer: customer,   // Nombre del cliente
          product: product,     // Producto
          unitsQty: unitsQty,   // Cantidad de unidades
          delivery: delivery,   // Fecha de Entrega
      },
      dataType: 'json',        // Esperamos una respuesta JSON
      success: function (response) {
          if (response.success) {
              alert('Order registered correctly');
              $('#registerOrderModal').modal('hide');  // Cerrar el modal si la actualización fue exitosa
              location.reload();  // Recargar la página para ver los cambios
          } else {
              alert('Error: ' + response.error);  // Mostrar el error si hubo algún problema
          }
      },
      error: function (xhr, status, error) {
          alert('Something went wrong while recording the data: ' + error);
      }
  });
});




/* ----------------------------EDIT PRODUCT--------------------------- */


$('#editProd').on('submit', function(event) {
  // Evitar que el formulario recargue la página
  event.preventDefault();   

  var code = $('#prodName').val();  // Obtener el valor del campo prodName

  // Primer solicitud AJAX para obtener la información del producto
  $.ajax({
    url: '../conexion/getProdInfo.php',  // Ruta al archivo PHP que devuelve los datos
    type: 'POST',
    data: { code: code },               // Enviar el número de producto como parámetro
    dataType: 'json',                   // Esperamos que la respuesta sea JSON
    success: function(response) {
      // Si se obtienen datos correctamente
      if (response.error) {
        // Si hay un error, mostrarlo en la consola o en el UI
        alert(response.error);
      } else {
        // Si no hay error, mostrar los datos en los inputs
        $('#idProd').val(response.idProd);
        $('#editProdName').val(response.editProdName);
        $('#editChemName').val(response.editChemName);
        $('#editProdType').val(response.editProdType);
        $('#idType').val(response.idType);
        $('#editMeasure').val(response.measure);
      }
    },
    error: function(xhr, status, error) {
      // Si ocurre un error en la solicitud AJAX
      alert('Something went wrong while recording the data: ' + error);
    }
  });

  // Segunda solicitud AJAX para obtener las opciones del select
  $.ajax({
    url: '../conexion/showTipoPre.php',  // Ruta al archivo PHP que obtiene las opciones del select
    type: 'POST',
    data: { code: code },               // Enviar el código del producto
    success: function(data) {
      // El servidor devuelve las opciones HTML
      $('#editPresentation').html(data);  // Actualizar el select con las opciones recibidas
    },
    error: function(xhr, status, error) {
      // Si ocurre un error en la solicitud AJAX
      alert('Something went wrong while recording the select options: ' + error);
    }
  });

  $.ajax({
    url: '../conexion/showFormula.php',  // Archivo PHP que obtiene los ingredientes
    type: 'POST',
    data: { code: code },               // Enviar el código del producto
    dataType: 'json',                   // Esperamos respuesta JSON
    success: function(response) {
        $('#spinner').hide();
        $('#editProduct').prop('disabled', false);

        if (response.error) {
            alert(response.error);  // Mostrar si hay error en la respuesta
        } else {
            // Limpiar el contenedor de ingredientes
            $('#ingredientsContainer').empty();  

            // Si hay ingredientes, agregar un título antes de los ingredientes
            if (response.ingredients.length > 0) {
                var title = $('<h3>').text('Ingredients').css({
                    'margin-top': '10px',
                    'margin-bottom': '5px',  
                    'font-weight': 'bold'
                });

                // Agregar el título al contenedor de ingredientes
                $('#ingredientsContainer').append(title);

                // Llenar el contenedor con los ingredientes
                response.ingredients.forEach(function(ingredient) {
                    // Crear un div para cada ingrediente
                    var ingredientDiv = $('<div>', { style: 'display: flex; margin-bottom: 10px;' });

                    // Crear el select para los ingredientes
                    var select = $('<select>', { name: 'ingredient[]', class: 'form-control', style: 'padding-right:20px;' });
                    select.append('<option value="' + ingredient.current.value + '" selected>' + ingredient.current.label + '</option>');

                    ingredient.options.forEach(function(option) {
                        select.append('<option value="' + option.value + '">' + option.label + '</option>');
                    });

                    ingredientDiv.append(select);

                    // Crear el input para la cantidad
                    var quantityInput = $('<input >', {
                        type: 'text',
                        name: 'quantity[]',
                        class: 'form-control',
                        placeholder: 'Cantidad',
                        style: 'margin-left:10px; width:75px;',
                        value: ingredient.current.quantity
                    });

                    ingredientDiv.append(quantityInput);

                    var curIngre = $('<input>', {
                      type: 'hidden',
                      name: 'currentIngredient[]',
                      value: ingredient.current.value
                    });
                    ingredientDiv.append(curIngre);

                    // Agregar el div con el select y el input al contenedor de ingredientes
                    $('#ingredientsContainer').append(ingredientDiv);
                });
            } else {
                // Si no hay ingredientes, podemos ocultar el contenedor o dejarlo vacío
                $('#ingredientsContainer').hide();  // o puedes usar .empty() si no quieres mostrar nada
            }
        }
    },
    error: function(xhr, status, error) {
        $('#spinner').hide();
        $('#editProduct').prop('disabled', false);
        alert('Something went wrong while loading the data: ' + error);
    }
});


  $.ajax({
    url: '../conexion/showFormuAct.php',  // Archivo PHP que obtiene los ingredientes
    type: 'POST',
    data: { code: code },               // Enviar el código del producto
    dataType: 'json',                   // Esperamos respuesta JSON
    success: function(response) {
        $('#spinner').hide();
        $('#editProduct').prop('disabled', false);

        // Limpiar el contenedor de ingredientes activos
        $('#ingredientsActContainer').empty();  

        // Si no hay ingredientes, ocultamos el contenedor o dejamos vacío
        if (response.ingredients.length === 0) {
            $('#ingredientsActContainer').empty(); // Puedes usar `.empty()` en lugar de `.hide()` si no quieres ocultarlo
        } else {
            // Agregar un título si hay ingredientes activos
            var title = $('<h3>').text('Active Ingredients').css({
                'margin-top': '15px', 
                'font-weight': 'bold'
            });

            // Agregar el título al contenedor
            $('#ingredientsActContainer').append(title);

            // Llenar el contenedor con los ingredientes
            response.ingredients.forEach(function(ingredient) {
                // Crear un div para cada ingrediente
                var ingredientDiv = $('<div>', { style: 'display: flex; margin-bottom: 10px;' });

                // Crear el select para los ingredientes
                var select = $('<select>', { name: 'actIngredient[]', class: 'form-control', style:'padding-right: 135px;' });
                select.append('<option value="' + ingredient.currentActive.value + '" selected>' + ingredient.currentActive.label + '</option>');

                // Agregar las opciones al select
                ingredient.options.forEach(function(option) {
                    select.append('<option value="' + option.value + '">' + option.label + '</option>');
                });

                ingredientDiv.append(select);

                // Crear el input para la cantidad
                var quantityInput = $('<input>', {
                    type: 'text',
                    name: 'quantityAct[]',
                    class: 'form-control',
                    placeholder: 'Cantidad',
                    style: 'margin-left: 10px; width: 75px;',
                    value: ingredient.currentActive.quantity // Aquí se toma el valor de cantidad desde PHP
                });

                ingredientDiv.append(quantityInput);
                
                var curActive = $('<input>', {
                  type: 'hidden',
                  name: 'curActiveAct[]',
                  value: ingredient.currentActive.value
                });
                ingredientDiv.append(curActive);
                

                // Agregar el div con el select y el input al contenedor de ingredientes
                $('#ingredientsActContainer').append(ingredientDiv);
            });
        }
    },
    error: function(xhr, status, error) {
        $('#spinner').hide();
        $('#editProduct').prop('disabled', false);
        // Ya no mostramos mensajes de error, ya que no queremos mostrar nada cuando no hay ingredientes
    }
});


$.ajax({
  url: '../conexion/showPackMat.php',  // Ruta al archivo PHP
  type: 'POST',
  data: { code: code },               // Enviar el código del producto
  dataType: 'json',                   // Esperamos respuesta en formato JSON
  success: function(response) {
      console.log(response);  // Agrega esta línea para ver la respuesta en la consola

      $('#spinner').hide();
      $('#editProduct').prop('disabled', false);

      // Verifica si la respuesta tiene la clave "materials"
      if (response && response.materials && response.materials.length > 0) {
          $('#materialsContainer').empty();
          var title = $('<h3>').text('Materials').css({
              'margin-top': '13px', 
              'font-weight': 'bold'
          });
          $('#materialsContainer').append(title);

          response.materials.forEach(function(material) {
              var materialDiv = $('<div>', { style: 'display: flex; margin-bottom: 10px;' });
              var select = $('<select>', { name: 'material[]', class: 'form-control' });
              select.append('<option value="' + material.currentActive.value + '" selected>' + material.currentActive.label + '</option>');
              material.options.forEach(function(option) {
                  select.append('<option value="' + option.value + '">' + option.label + '</option>');
              });
              materialDiv.append(select);

              var quantityInput = $('<input>', {
                  type: 'text',
                  name: 'quantityMat[]',
                  class: 'form-control',
                  placeholder: 'Cantidad',
                  style: 'margin-left: 10px; width: 100px;',
                  value: material.currentActive.quantity
              });
              materialDiv.append(quantityInput);

              var curMaterial = $('<input>',{
                type: 'hidden',
                name: 'curMaterial[]',
                value: material.currentActive.value
              });
              materialDiv.append(curMaterial);

              $('#materialsContainer').append(materialDiv);
          });
      } else {
          $('#materialsContainer').append('<p>No materials found for this product.</p>');
      }
  },
  error: function(xhr, status, error) {
      $('#spinner').hide();
      $('#editProduct').prop('disabled', false);
      console.log("AJAX error:", status, error); // Ver detalles del error
      $('#materialsContainer').append('<p>Error fetching materials.</p>');
  }
});




$('#editProd').on('hidden.bs.modal', function () {
  // Reseteamos el formulario
  location.reload();
});


});

$('#editProduct').on('click', function(event) {
  event.preventDefault(); // Evitar que el formulario recargue la página

  // Crear el objeto con los datos del formulario
  var productData = {
    code: $('#prodName').val(),  // Definir la variable 'code'
    productName: $('#editProdName').val(),
    chemName: $('#editChemName').val(),
    presentation: $('#editPresentation').val(),
    measure: $('#editMeasure').val(),
    prodType: $('#idType').val(),
    currentIngredient: [], 
    ingredient: [],
    quantity: [],
    currentActive: [],
    actIngredient: [],
    quantityAct: [],
    curMaterial: [],
    material: [],
    quantityMat: []
  };

  // Recopilar los ingredientes
  $('#ingredientsContainer select[name="ingredient[]"]').each(function() {
    productData.ingredient.push($(this).val());
  });
  $('#ingredientsContainer input[name="quantity[]"]').each(function() {
    productData.quantity.push($(this).val());
  });
  $('#ingredientsContainer input[name="currentIngredient[]"]').each(function() {
    productData.currentIngredient.push($(this).val());
  });

  // Recopilar ingredientes activos
  $('#ingredientsActContainer select[name="actIngredient[]"]').each(function() {
    productData.actIngredient.push($(this).val());
  });
  $('#ingredientsActContainer input[name="quantityAct[]"]').each(function() {
    productData.quantityAct.push($(this).val());
  });
  $('#ingredientsActContainer input[name="curActiveAct[]"]').each(function() {
    productData.currentActive.push($(this).val());
  });

  // Recopilar materiales
  $('#materialsContainer select[name="material[]"]').each(function() {
    productData.material.push($(this).val());
  });
  $('#materialsContainer input[name="quantityMat[]"]').each(function() {
    productData.quantityMat.push($(this).val());
  });
  $('#materialsContainer input[name="curMaterial[]"]').each(function() {
    productData.curMaterial.push($(this).val());
  });

  // Enviar los datos del formulario al servidor con fetch
  $.ajax({
    url: '../conexion/editProduct.php',  // URL a la que se envían los datos
    type: 'POST',
    data: productData,  // Los datos que se envían
    dataType: 'json'  // El formato de la respuesta esperado
  })
  .then(response => {
    // Si la respuesta es JSON, se maneja aquí
    console.log('Success:', response);
    
    // Si la respuesta del servidor indica éxito
    if (response.success) {
      alert('Successfully updated product.');
      $('#editProd').modal('hide');  // Cerrar el modal
      location.reload();  // Recargar la página
    } else {
      alert('Error: ' + response.error || 'Something went wrong while updating the product.');
    }
  })
  .catch((error) => {
    console.error('Error:', error);
    alert('Something went wrong while sending the data to the server.');
  });
});



$(document).ready(function() {
  // Captura el evento click del enlace "Status"
  $('a[data-bs-target="#viewProd"]').on('click', function(event) {
    event.preventDefault(); // Evita la acción predeterminada del enlace
    
    // Obtén el código del producto desde el atributo 'data-id' del enlace
    var code = $(this).data('id');
    
    // Realiza una solicitud AJAX para obtener las opciones de estado
    $.ajax({
      url: '../conexion/getProdInfo.php',  // Ruta al archivo PHP que devuelve los datos
      type: 'POST',
      data: { code: code },               // Enviar el número de producto como parámetro
      dataType: 'json',                   // Esperamos una respuesta JSON
      success: function(response) {
        // Si se obtienen datos correctamente
        if (response.error) {
          alert(response.error);
        } else {
          // Si no hay error, mostrar los datos en los inputs
          $('#viewProdName').val(response.editProdName);
          $('#viewChemName').val(response.editChemName);
          $('#viewProdType').val(response.editProdType);
          $('#viewMeasure').val(response.measure);
        }
      },
      error: function(xhr, status, error) {
        alert('Something went wrong while loading the data: ' + error);
      }
    });

    $.ajax({
      url: '../conexion/showTipoPre.php',  // Ruta al archivo PHP que obtiene las opciones del select
      type: 'POST',
      data: { code: code },               // Enviar el código del producto
      success: function(data) {
        // El servidor devuelve las opciones HTML del select
        var options = $(data);  // Convertir el string HTML en un objeto jQuery
        var tipoNombre = options.first().text();  // Extraer el texto de la primera opción (tipo_nombre)

        // Asignar solo el tipo_nombre al campo de presentación
        $('#viewPresentation').val(tipoNombre);  // Actualizar el input con tipo_nombre
      },
      error: function(xhr, status, error) {
        // Si ocurre un error en la solicitud AJAX
        alert('Something went wrong loading the select options: ' + error);
      }
    });

    $.ajax({
      url: '../conexion/showFormula.php',  // Archivo PHP que obtiene los ingredientes
      type: 'POST',
      data: { code: code },               // Enviar el código del producto
      dataType: 'json',                   // Esperamos respuesta JSON
      success: function(response) {
          $('#spinner').hide();
          $('#editProduct').prop('disabled', false);
  
          if (response.error) {
              alert(response.error);  // Mostrar si hay error en la respuesta
          } else {
              // Limpiar el contenedor de ingredientes
              $('#showIngreContainer').empty();  
  
              // Si hay ingredientes, agregar un título antes de los ingredientes
              if (response.ingredients.length > 0) {
                  var title = $('<h3>').text('Ingredients').css({
                      'margin-bottom': '10px',
                      'margin-top': '20px',
                      'font-weight': 'bold'
                  });
  
                  // Agregar el título al contenedor de ingredientes
                  $('#showIngreContainer').append(title);
  
                  // Agregar un espacio de 20px debajo del título
                  $('#showIngreContainer').append('<div style="margin-bottom: 20px;"></div>');
  
                  // Llenar el contenedor con los ingredientes
                  response.ingredients.forEach(function(ingredient) {
                      // Crear un div para mostrar cada ingrediente
                      var ingredientDiv = $('<div>').css({
                          'margin-bottom': '10px',
                          'display': 'flex',
                          'align-items': 'center'
                      }); 
  
                      // Crear un input para la cantidad
                      var curIngre = $('<input>', {
                        type: 'text',
                        class: 'form-control',
                        name: 'ingre',
                        readonly: true,
                        placeholder: 'Cantidad',
                        style: 'margin-left: 10px; width: 70px;',
                        value: ingredient.current.quantity // Agregar la cantidad del ingrediente
                      });
  
                      // Crear un input para mostrar la descripción del ingrediente
                      var description = $('<input>', {
                        type: 'text',
                        class: 'form-control',
                        name: 'description',
                        readonly: true,
                        style: 'margin-left: 2px; width: 250px;',  // Un poco de espacio adicional para la descripción
                        value: ingredient.current.label // Descripción del ingrediente
                      });
  
                      // Agregar los inputs al div
                      ingredientDiv.append(description, curIngre );
  
                      // Agregar el div con el input y la descripción al contenedor
                      $('#showIngreContainer').append(ingredientDiv);
                  });
              } else {
                  // Si no hay ingredientes, podemos ocultar el contenedor o dejarlo vacío
                  $('#showIngreContainer').hide();  // o puedes usar .empty() si no quieres mostrar nada
              }
          }
      },
      error: function(xhr, status, error) {
          $('#spinner').hide();
          alert('Something went wrong while loading the data: ' + error);
      }
  });


  $.ajax({
    url: '../conexion/showFormuAct.php',  // Archivo PHP que obtiene los ingredientes activos
    type: 'POST',
    data: { code: code },               // Enviar el código del producto
    dataType: 'json',                   // Esperamos respuesta JSON
    success: function(response) {
        $('#spinner').hide();
        $('#editProduct').prop('disabled', false);

        // Limpiar el contenedor de ingredientes activos
        $('#showActContainer').empty();  

        // Si hay ingredientes activos, agregar un título antes de los ingredientes
        if (response.ingredients.length > 0) {
            var title = $('<h3>').text('Active Ingredients').css({
                'margin-bottom': '10px',
                'margin-top': '15px',
                'font-weight': 'bold'
            });

            // Agregar el título al contenedor de ingredientes activos
            $('#showActContainer').append(title);

            // Agregar un espacio de 20px debajo del título
            $('#showActContainer').append('<div style="margin-bottom: 20px;"></div>');

            // Llenar el contenedor con los nombres de los ingredientes activos
            response.ingredients.forEach(function(ingredient) {
                // Crear un div para mostrar cada ingrediente activo
                var ingredientDiv = $('<div>').css({
                    'margin-bottom': '10px',
                    'display': 'flex',
                    'align-items': 'center'
                });

                var curIngreAct = $('<input>', {
                  type: 'text',
                  name: 'ingre',
                  class: 'form-control',
                  readonly: true,
                  placeholder: 'Cantidad',
                  style: 'margin-left: 10px; width: 70px;',
                  value: ingredient.currentActive.quantity // Agregar la cantidad del ingrediente
                });

                // Crear un input solo para mostrar el nombre del ingrediente activo
                var ingredientName = $('<input>', {
                    type: 'text',
                  class: 'form-control',
                    readonly: true,
                    style: 'margin-left: 3px; width: 250px;',
                    value: ingredient.currentActive.label // Aquí se muestra solo el nombre del ingrediente activo
                });

                // Agregar el input con el nombre del ingrediente activo al div
                ingredientDiv.append(ingredientName, curIngreAct);

                // Agregar el div con el nombre del ingrediente activo al contenedor
                $('#showActContainer').append(ingredientDiv);
            });
        } else {
            // Si no hay ingredientes activos, podemos ocultar el contenedor o dejarlo vacío
            $('#showActContainer').empty();  // o puedes usar .empty() si no quieres mostrar nada
        }
    },
    error: function(xhr, status, error) {
        $('#spinner').hide();
        alert('Something went wrong while loading the active ingredients: ' + error);
    }
  });

  $.ajax({
    url: '../conexion/showPackMat.php',  // Archivo PHP que obtiene los materiales de empaque
    type: 'POST',
    data: { code: code },               // Enviar el código del producto
    dataType: 'json',                   // Esperamos respuesta JSON
    success: function(response) {
        $('#spinner').hide();
        $('#editProduct').prop('disabled', false);

        // Limpiar el contenedor de materiales de empaque
        $('#showMatContainer').empty();  

        // Si hay materiales de empaque, agregar un título antes de los materiales
        if (response.materials.length > 0) {
            var title = $('<h3>').text('Materials').css({
                'margin-bottom': '10px', 
                'margin-top': '10px',
                'font-weight': 'bold'

            });

            // Agregar el título al contenedor de materiales
            $('#showMatContainer').append(title);

            // Agregar un espacio de 20px debajo del título
            $('#showMatContainer').append('<div style="margin-bottom: 20px;"></div>');

            // Llenar el contenedor con los materiales
            response.materials.forEach(function(material) {
                // Crear un div para mostrar cada material de empaque
                var materialDiv = $('<div>').css({
                    'margin-bottom': '10px',
                    'display': 'flex',
                    'align-items': 'center'
                });

                
                var quantityInput = $('<input>', {
                  type: 'text',
                  name: 'quantityMat[]',
                  class: 'form-control',
                  placeholder: 'Cantidad',
                  readonly: true,
                  style: 'margin-left: 10px; width: 70px;',
                  value: material.currentActive.quantity
              });

                // Crear un input solo para mostrar el nombre del material de empaque
                var materialName = $('<input>', {
                    type: 'text',
                    class: 'form-control',
                    readonly: true,
                    style: 'margin-left: 3px; width: 250px;',
                    value: material.currentActive.label // Aquí se muestra solo el nombre del material
                });

                // Agregar el input con el nombre del material al div
                materialDiv.append(materialName, quantityInput);

                // Agregar el div con el nombre del material al contenedor
                $('#showMatContainer').append(materialDiv);
            });
        } else {
            // Si no hay materiales de empaque, podemos ocultar el contenedor o dejarlo vacío
            $('#showMatContainer').hide();  // o puedes usar .empty() si no quieres mostrar nada
        }
    },
    error: function(xhr, status, error) {
        $('#spinner').hide();
        alert('Something went wrong while loading the packaging materials: ' + error);
    }
  });
  
  });
});
