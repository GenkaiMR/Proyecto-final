

/*------------------------INGREDIENTS------------------------------ */
document.addEventListener("DOMContentLoaded", function () {
  
    // Función genérica para obtener datos de ingredientes, ingredientes activos o materiales
    function getOptions(url) {
      return fetch(url) // Ajusta la ruta si es necesario
        .then(response => response.text())
        .catch(error => console.error('Something went wrong while getting data: ', error));
    }
  
    // Función para agregar un nuevo elemento a un contenedor
    function addNewItem(containerId, selectName, inputName, url) {
      const productContainer = document.getElementById(containerId);
      const newProductItem = document.createElement("div");
      newProductItem.classList.add(containerId.replace('product-', '') + '-item');
      newProductItem.innerHTML = `
        <div style="display: flex;">
          <div style="display: flex;">
            <select name="${selectName}[]" class ="form-control" style="margin-top: 10px; width:234px;">
            </select>
            <div id="product-quantity-container">
              <input  type="text" name="${inputName}[]" class ="form-control" placeholder="Amount" style="margin-top: 10px; margin-left: 10px; width: 60px; border: 1;">
            </div>
          </div>
          <div class="contbt">
            <button type="button" class="btn btn-danger btn-remove-${containerId.replace('product-', '')}" 
                    style="padding: 4px; margin-top: 10px; margin-left: 10px;">-</button>
          </div>
        </div>
      `;
      
      // Obtener las opciones y agregarlas al select
      getOptions(url).then(options => {
        const select = newProductItem.querySelector(`select[name="${selectName}[]"]`);
        select.innerHTML = options;  // Aquí insertamos las opciones recibidas desde PHP
      });
  
      productContainer.appendChild(newProductItem);
  
      // Agregar evento de eliminación para el nuevo botón
      newProductItem.querySelector(`.btn-remove-${containerId.replace('product-', '')}`).addEventListener("click", function () {
        newProductItem.remove();
      });
    }
  
    document.querySelector(".btn-add-ingredient").addEventListener("click", function () {
      addNewItem("product-ingredient-container", "ingredient", "quantity", '../conexion/getIngredients.php');
    });
    
  
    document.querySelector(".btn-add-active").addEventListener("click", function () {
      addNewItem("product-active-container", "activeIng", "quantityAct", '../conexion/getActiveIngre.php');
    });
  
    document.querySelector(".btn-add-material").addEventListener("click", function () {
      addNewItem("product-material-container", "material", "quantityMat", '../conexion/getPackingMat.php');
    });
  
  
    document.querySelector(".btn-add-supleingredient").addEventListener("click", function () {
      addNewItem("product-supleingredient-container", "ingredientSuple", "quantitySup", '../conexion/getIngreSuple.php');
    });
  
    document.querySelector(".btn-add-suplematerial").addEventListener("click", function () {
      addNewItem("product-suplematerial-container", "materialSuple", "quantityMatSup", '../conexion/getPackingMatSup.php');
    });
  
  
  });
  
  
  
  /* ----------------------------------------SELECT TYPE OF PRODUCT--------------------------- */
  
  function mostrarDiv() {
    const select = document.getElementById("prodType");
    const div1 = document.getElementById("farmaDiv");
    const div2 = document.getElementById("protDiv");
  
    if (select.value === "FARMA") {
      div1.style.display = "block";  
      div2.style.display = "none";   
    } else if (select.value === "SUPLE") {
      div1.style.display = "none";   
      div2.style.display = "block";  
    } else {
      div1.style.display = "none";  
      div2.style.display = "none";  
    }
  }