$(document).on("click", ".view", function(event) {
    event.preventDefault();
    // Obtener el número de orden desde el atributo data-id del botón clicado
    var orderNumber = $(this).data("id");
    var type = $(this).closest("tr").find(".type-product").text().trim();
    var name = $(this).closest("tr").find(".product-name").text().trim();
    
    $('#orderNumber').val(orderNumber); // Si deseas actualizar algún campo en el formulario.
    
    // Abrir el PDF en una nueva ventana con los parámetros necesarios.
    window.open("../Docs/doc.php?orderNumber=" + orderNumber + "&TypeProd=" + encodeURIComponent(type) + "&NameProd=" + encodeURIComponent(name), "_blank", "width=800,height=600");
});
