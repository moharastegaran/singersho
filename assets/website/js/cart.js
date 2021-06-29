function updateCartTable(response) {
    let details = JSON.parse(response.cart.details);
    if(!Array.isArray(details)){
        let _details = [];
        for(const id in details){
            _details.push(details[id]);
        }
        details = _details;
    }
    $(".cart__table tbody").empty();
    for (let i = 0; i < details.length; i++) {
        let html = "<tr data-id='"+details[i].id+"' data-type='"+details[i].type+"'>";
        switch (details[i].type) {
            case 'package' :
                html += "<td><div class='cart__img'>\n<div class='badge badge-danger'>پکیج</div>\n</div></td>";
                html += "<td><a href='product.html?id="+details[i].id+"'>"+details[i].full_name+"</a></td>";
                break;
            case 'advisor' :
                html += "<td><div class='cart__img'>\n<div class='badge badge-primary'>مشاوره</div>\n</div></td>";
                html += "<td><a href='artist.html?id="+details[i].id+"'>"+details[i].full_name+"</a></td>";
                break;
            case 'teammate' :
                html += "<td><div class='cart__img'>\n<div class='badge badge-warning'>هنرمند</div>\n</div></td>";
                html += "<td>"+details[i].full_name+"</td>";
                break;
            case 'studio' :
                html += "<td><div class='cart__img'>\n<div class='badge badge-success'>استودیو</div>\n</div></td>";
                html += "<td><a href='studio.html?id="+details[i].id+"'>"+details[i].full_name+"</a></td>";
                break;
        }
        html +="<td><span class='cart__price'>"+details[i].price+" تومان</span></td>\n";
        html += "<td><button class='cart__delete' type='button'>\n" +
            "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'>\n" +
            "<path d='M13.41,12l6.3-6.29a1,1,0,1,0-1.42-1.42L12,10.59,5.71,4.29A1,1,0,0,0,4.29,5.71L10.59,12l-6.3,6.29a1,1,0,0,0,0,1.42,1,1,0,0,0,1.42,0L12,13.41l6.29,6.3a1,1,0,0,0,1.42,0,1,1,0,0,0,0-1.42Z'></path>\n"+
            "</svg>\n</button>\n</td>";
        html += "</tr>";
        $(".cart__table tbody").append(html);
    }
    $("._cart.final_cost").text(response.cart.final_cost);
}

$(window).on('load',function (){
    $.ajaxSetup({
        headers: {
            authorization: "Bearer " + localStorage.getItem("accessToken")
        }
    })

    $.ajax({
        method: 'GET',
        url: 'http://127.0.0.1:8000/api/cart',
        success: function (response) {
            if (response != null) {
                updateCartTable(response);
            }
        },
        error : function (error){
            popupCartError();
        }
    });

    $.get('http://127.0.0.1:8000/api/me',function (response){
        if(!response.error){
            const parent = $("#sign-form-cart");
            parent.find("[name='name']").val(response.data.user.first_name+' '+response.data.user.first_name);
            parent.find("[name='email']").val(response.data.user.email);
            parent.find("[name='mobile']").val(response.data.user.mobile);
        }
    })
});

$(document).ready(function (response){
    $(document).on('click','.cart__delete',function (e){
        e.preventDefault();
        const $this = $(this);
        console.log('data-id : '+$this.closest('tr').data('id'));
        console.log('data-type : '+$this.closest('tr').data('type'));
        $.ajax({
            method : 'DELETE',
            url : 'http://127.0.0.1:8000/api/cart/'+$this.closest('tr').data('type'),
            data : {
                _method : 'DELETE',
                itemId : $this.closest('tr').data('id')
            },
            success : function (response){
                if(!response.error){
                    updateCartTable(response);
                    updateCartDropdown(response);
                }
            },
            error : function (error){
                console.log("xhr : "+JSON.stringify(error));
                // popupCartError();
            }
        });
    });
});