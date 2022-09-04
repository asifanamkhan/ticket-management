jQuery(function($){

    $(document).on('click', '.concert-toggle', function (e) {

        let concerts = $(this).data('concerts');
        let count = 0

        for (let concert in concerts) {
            count++
        }

        if (count < 1 && $(this).data('type') == 'join_concert') {
            console.log($('#nav-type-join-concert').find('.add-on'))
            $('#nav-type-join-concert').find('.add-on').attr('disabled', true)
        }
        $('.concert-toggle').removeClass('active btn-success').addClass('btn-primary')
        $(this).addClass('active btn-success')

        
    })
    $(document).on('change', '.activity-qty', function() {

        let package_type_id = $(this).data('package-type-id');
        let package_id = $(this).data('package-id');
        let day = $(this).data('day');
        let price = $(this).data('price');
        let qty = $(this).data('qty');
        let add_on_id = $(this).data('addon-id');
        let add_on_price = $(this).data('addon-price');
        let add_on_qty = $(this).val();

        if (add_on_qty < 1) return;
        

        let formdData = {
            package_type_id: package_type_id,
            package_id: package_id,
            day: day,
            price: price,
            qty: qty,
            add_on_id: add_on_id,
            add_on_price: add_on_price,
            add_on_qty: add_on_qty
        }

        console.log(formdData)

        $.ajax({
            type: 'post',
            url: `/cart/check-activity`,
            data: formdData,
            responseType: 'json',
            success: function(resData) {
                console.log(resData)
                if (resData.success == true) {
                    $.ajax({
                        type: 'post',
                        url: '/cart',
                        data: formdData,
                        responseType: 'json',
                        success: function(res) {
                            console.log(res)
                           if (res.success == true) {
                            $.ajax({
                                type: 'get',
                                url: '/cart-amount',
                                responseType: 'json',
                                success: function(cart) {
                                    console.log(cart)
                                    let total = parseFloat(cart.total);
                                    console.log(total)
                                    let vat = total - (total / 1.15);
                                    console.log(vat)
                                    let subtotal = total - vat;
                                    console.log(subtotal)
                                    $('#total').text(Number(total).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
                                    $('#sub-total').text(Number(subtotal).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
                                    $('#vat-amount').text(Number(vat).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
                                    // $('#app').html(res.html)
                                }
                            })
                           }
                        }
                    })
                } else {
                    alert(resData.data)
                }
            }
        })

        
    })

    $(document).on('change', '.concert-qty', function() {

        let qty = $(this).data('qty')
        let concert_qty = $(this).val()
        let price = $(this).data('package-price')
        let package_id = $(this).data('package-id')
        let day = $(this).data('day')
        let package_type_id = $(this).data('package-type-id')
        let concert_id = $(this).data('concert-id')
        let concert_price = $(this).data('concert-price')
        let join_concert = $(this).data('concert')

        if (concert_qty < 1) return;

        let formdData = {
            package_type_id: package_type_id,
            package_id: package_id,
            day: day,
            price: price,
            qty: qty,
            concert_id: concert_id,
            concert_price: concert_price,
            concert_qty: concert_qty,
            join_concert: join_concert
        }

        console.log(formdData)

        $.ajax({
            type: 'post',
            url: `/cart/check-activity`,
            data: formdData,
            responseType: 'json',
            success: function(resData) {
                console.log(resData)
                if (resData.success == true) {
                    $.ajax({
                        type: 'post',
                        url: '/cart',
                        data: formdData,
                        responseType: 'json',
                        success: function(res) {
                            console.log(res)
                           if (res.success == true) {
                            $.ajax({
                                type: 'get',
                                url: '/cart-amount',
                                responseType: 'json',
                                success: function(cart) {
                                    console.log(cart)
                                    let total = parseFloat(cart.total);
                                    console.log(total)
                                    let vat = total - (total / 1.15);
                                    console.log(vat)
                                    let subtotal = total - vat;
                                    console.log(subtotal)
                                    $('#total').text(Number(total).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
                                    $('#sub-total').text(Number(subtotal).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
                                    $('#vat-amount').text(Number(vat).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","))
                                    // $('#app').html(res.html)
                                }
                            })
                           }
                        }
                    })
                } else {
                    alert(resData.data)
                }
            }
        })

        
    })

    $(document).on('change', '.update-activity-qty', function() {

        let package_type_id = $(this).data('package-type-id');
        let package_id = $(this).data('package-id');
        let day = $(this).data('day');
        let price = $(this).data('price');
        let qty = $(this).data('qty');
        let add_on_id = $(this).data('addon-id');
        let add_on_price = $(this).data('addon-price');
        let add_on_qty = $(this).val();
        let join_concert = $(this).data('concert')

        let formdData = {
            package_type_id: package_type_id,
            package_id: package_id,
            day: day,
            price: price,
            qty: qty,
            add_on_id: add_on_id,
            add_on_price: add_on_price,
            add_on_qty: add_on_qty,
            join_concert: join_concert
        }

        console.log(formdData)

        

        if (add_on_qty < 1) {
            $.ajax({
                type: 'post',
                url: '/cart/remove/addon',
                data: {
                    package_type_id: package_type_id,
                    package_id: package_id,
                    day: day,
                    price: price,
                    qty: qty,
                    add_on_id: add_on_id,
                    add_on_price: add_on_price,
                    join_concert: join_concert
                },
                responseType: 'json',
                success: function(res) {
                    console.log(res)
                    $('#app').html(res.html)
                }
            })
            return;
        }

        

        // console.log(formdData)

        $.ajax({
            type: 'post',
            url: `/cart/check-activity`,
            data: formdData,
            responseType: 'json',
            success: function(res) {
                console.log(res)
                if (res.success == true) {
                    $.ajax({
                        type: 'post',
                        url: '/cart',
                        data: formdData,
                        responseType: 'json',
                        success: function(response) {
                            console.log(response)
                           if (response.success == true) {
                            $('#app').html(response.html)
                           }
                        }
                    })
                } else {
                    alert(res.data)
                }
            }
        })
    })

    $(document).on('click', '.add-to-cart', function() {
       
        let parent = $(this).parent()
        let qty = parent.find('.qty').val()
        let price = parent.find('.price').val()
        let package_id = parent.data('package-id')
        let day = parent.data('day')
        let package_type_id = parent.data('package-type-id')

        if (qty < 1) return;

        let formdData = {
            package_type_id: package_type_id,
            package_id: package_id,
            day: day,
            price: price,
            qty: qty,
        }

        console.log(formdData)

        console.log(`/package/${package_id}/quantity`)

        $.ajax({
            type: 'get',
            url: `/package/${package_id}/quantity`,
            responseType: 'json',
            success: function(data) {
                if (data.success === true) {
                    if (qty <= data.qty) {
                        $.ajax({
                            type: 'post',
                            url: '/cart',
                            data: formdData,
                            responseType: 'json',
                            success: function(res) {
                                console.log(res)
                                $('#app').html(res.html)
                            }
                        })
                    } else {
                        alert('You can add maximum quanity for this package is ' + data.qty)
                    }
                    
                } else {
                    alert(data.data)
                }
                
            }
        })
    })

    $(document).on('click', '.join_concert', function() {

        let package_type_id = $(this).data('package-type-id');
        let package_id = $(this).data('package-id');
        let day = $(this).data('day');
        let price = $(this).data('price');
        let qty = $(this).data('qty');
        let join_concert = $(this).data('concert');

        // if (qty < 1) return;

        let formdData = {
            package_type_id: package_type_id,
            package_id: package_id,
            day: day,
            price: price,
            qty: qty,
            join_concert: join_concert
        }

        console.log(formdData)

        $.ajax({
            type: 'post',
            url: '/cart',
            data: formdData,
            responseType: 'json',
            success: function(res) {
                console.log(res)
               if (res.success == true) {
                $('#app').html(res.html)
               }
            }
        })
    })

    $(document).on('click', '.add-concert', function() {

        let qty = $(this).data('qty')

        let price = $(this).data('package-price')
        let package_id = $(this).data('package-id')
        let day = $(this).data('day')
        let package_type_id = $(this).data('package-type-id')
        let concert_id = $(this).data('concert-id')
        let concert_price = $(this).data('concert-price')
        let join_concert = $(this).data('concert')
        // let total_addon_price = concert_price * qty
        // let subtotal = total_addon_price + (qty * price)

        if (qty < 1) return;

        let formdData = {
            package_type_id: package_type_id,
            package_id: package_id,
            day: day,
            price: price,
            qty: qty,
            concert_id: concert_id,
            concert_price: concert_price,
            concert_qty: qty,
            join_concert: join_concert
        }

        console.log(formdData)

        $.ajax({
            type: 'post',
            url: '/cart',
            data: formdData,
            responseType: 'json',
            success: function(res) {
                console.log(res)
                $('#app').html(res.html)
            }
        })
    })

    $(document).on('change', '.concert-activity-qty', function() {

        let qty = $(this).data('qty')
        let concert_qty = $(this).val();
        let price = $(this).data('package-price')
        let package_id = $(this).data('package-id')
        let day = $(this).data('day')
        let package_type_id = $(this).data('package-type-id')
        let concert_id = $(this).data('concert-id')
        let concert_price = $(this).data('concert-price')
        let join_concert = $(this).data('concert')

        if (concert_qty < 1) return;

        let formdData = {
            package_type_id: package_type_id,
            package_id: package_id,
            day: day,
            price: price,
            qty: qty,
            concert_id: concert_id,
            concert_price: concert_price,
            concert_qty: concert_qty,
            join_concert: join_concert
        }

        console.log(formdData)

        $.ajax({
            type: 'post',
            url: `/cart/check-activity`,
            data: formdData,
            responseType: 'json',
            success: function(res) {
                console.log(res)
                if (res.success == true) {
                    $.ajax({
                        type: 'post',
                        url: '/cart',
                        data: formdData,
                        responseType: 'json',
                        success: function(response) {
                            console.log(response)
                           if (response.success == true) {
                            $('#app').html(response.html)
                           }
                        }
                    })
                } else {
                    alert(res.data)
                }
            }
        })
    })

    $(document).on('click', '.remove-concert', function() {

        let qty = $(this).data('qty')

        let price = $(this).data('package-price')
        let package_id = $(this).data('package-id')
        let day = $(this).data('day')
        let package_type_id = $(this).data('package-type-id')
        let concert_id = $(this).data('concert-id')
        let concert_price = $(this).data('concert-price')
        let join_concert = $(this).data('concert')
        // let total_addon_price = concert_price * qty
        // let subtotal = total_addon_price + (qty * price)
        

        let formdData = {
            package_type_id: package_type_id,
            package_id: package_id,
            day: day,
            price: price,
            qty: qty,
            concert_id: concert_id,
            concert_price: concert_price,
            concert_qty: qty,
            join_concert: join_concert
        }

        $.ajax({
            type: 'post',
            url: '/cart/remove/concert',
            data: formdData,
            responseType: 'json',
            success: function(res) {
                console.log(res)
                $('#app').html(res.html)
            }
        })
    })

    $(document).on('click', '.add-on', function(){

        let parent = $(this).closest('.card').find('.add-to-cart-content')
        let qty = parent.find('.qty').val()

        let price = parent.find('.price').val()
        let package_id = parent.data('package-id')
        let day = parent.data('day')
        let package_type_id = parent.data('package-type-id')
        let add_on_id = $(this).data('id')
        let add_on_price = $(this).data('price')
        let join_concert = $(this).data('concert')
        // let total_addon_price = add_on_price * qty
        // let subtotal = total_addon_price + (qty * price)

        if (qty < 1) return;

        let formdData = {
            package_type_id: package_type_id,
            package_id: package_id,
            day: day,
            price: price,
            qty: qty,
            add_on_id: add_on_id,
            add_on_price: add_on_price,
            add_on_qty: qty,
            join_concert: join_concert
        }

        console.log(formdData)

        $.ajax({
            type: 'get',
            url: `/package/${package_id}/quantity`,
            responseType: 'json',
            success: function(data) {
                if (data.success === true) {
                    if (qty <= data.qty) {
                        $.ajax({
                            type: 'post',
                            url: '/cart',
                            data: formdData,
                            responseType: 'json',
                            success: function(res) {
                                console.log(res)
                                $('#app').html(res.html)
                            }
                        })
                    } else {
                        alert('You can add maximum quanity for this package is ' + data.qty)
                    }
                    
                } else {
                    alert(data.data)
                }
                
            }
        })
    })

    $(document).on('click', '.remove-addon', function() {

        let parent = $(this).closest('.card').find('.add-to-cart-content')
        let qty = parent.find('.qty').val()

        let price = parent.find('.price').val()
        let package_id = parent.data('package-id')
        let day = parent.data('day')
        let package_type_id = parent.data('package-type-id')
        let add_on_id = $(this).data('id')
        let add_on_price = $(this).data('price')
        let join_concert = $(this).data('concert')
        // let total_addon_price = add_on_price * qty
        // let subtotal = total_addon_price + (qty * price)

        let formdData = {
            package_type_id: package_type_id,
            package_id: package_id,
            day: day,
            price: price,
            qty: qty,
            add_on_id: add_on_id,
            add_on_price: add_on_price,
            join_concert: join_concert
        }

        $.ajax({
            type: 'post',
            url: '/cart/remove/addon',
            data: formdData,
            responseType: 'json',
            success: function(res) {
                console.log(res)
                $('#app').html(res.html)
            }
        })
    })

    $(document).on('click', '.remove-cart', function(){

        let parent = $(this).closest('.add-to-cart-content')
        let package_id = parent.data('package-id')
        let day = parent.data('day')
        let package_type_id = parent.data('package-type-id')
        let data = {
            package_type_id: package_type_id,
            package_id: package_id,
            day: day
        }

        console.log(data)

        $.ajax({
            type: 'DELETE',
            url: '/cart/' + package_id,
            data: data,
            responseType: 'json',
            success: function(res) {
                console.log(res)
                $('#app').html(res.html)
            }
        })
    })
})