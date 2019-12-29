$(document).ready(function() {
    $("#pro_name").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "search_option.php",
                type: "POST",
                data: { project_name: request['term'] },
                dataType: 'json',
                success: function (data) {
                    response($.map(data, function (el) {
                        return {
                            id: el.id,
                            value: el.value
                        };
                    }));
                }

            });
        },
        select: function (event,ui) {
            $('#pro_id').val(ui.item.id);
        }
    });

    $("#item_name").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "search_option.php",
                type: "POST",
                data: { product_details: request['term'] },
                dataType: 'json',
                success: function (product_data) {
                    response($.map(product_data, function (el) {
                        return {
                            id: el.id,
                            value: el.product_name,
                            uom_code: el.uom_code,
                            unit_cost: el.unit_cost
                        };
                    }));
                }

            });
        },
        select: function (event,ui) {
            $('#item_id').val(ui.item.id);
            $('#uom').val(ui.item.uom_code);
            $('#unit_cost').val(ui.item.unit_cost);
        }
    });
});