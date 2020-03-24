</body>

<script src="js/jquery-2.js"></script>
<script src="js/pusher.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/jquery.js"></script>
<script src="js/plugins.js"></script>
<script src="js/jquery_002.js"></script>
<script src="js/datatable.js"></script>
<script src="js/owl.js"></script>
<script src="js/animate.js"></script>
<script src="js/select2.min.js"></script>
<script>
function showTimex() {
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";

    if (h == 0) {
        h = 12;
    }
    if (h > 12) {
        h = h - 12;
        session = "PM";
    }
    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;
    var time = h + ":" + m + ":" + s + "" + session;
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    var curWeekDay = days[date.getDay()];
    var curDay = date.getDate();
    var curMonth = months[date.getMonth()];
    var curYear = date.getFullYear();
    var today = curWeekDay + " " + curDay + " " + curMonth + " ";
    document.getElementById("MyClockDisplayx").innerText = today + "" + time;
    document.getElementById("MyClockDisplayx").textContent = today + "" + time;
    setTimeout(showTimex, 1000);
}
showTimex();
</script>





<script>
$('.number').on('keypress', function(e) {
    if (e.which == 32)
        return false;
});

function valueChange(el) {
    $('#betLabel').text(visual_number_format($(el).val()));
    $('#modalPossibleAmountLabel').text(visual_number_format($('#modalBetRate').val() * $(el).val()));
}

$('.amountBtn').click(function() {
    $('.amountBtn').removeClass('active');
    $(this).addClass('active');
    var amount = $(this).text();
    $('#bet').val(amount).trigger('change')
})
</script>


<script>
$(document).ready(function() {
    $('.itemSlider').owlCarousel({
        margin: 0,
        loop: true,
        autoplay: true,
        autoplayTimeout: 4000,
        nav: true,
        smartSpeed: 800,
        dots: false,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsive: {
            0: {
                items: 4
            },
            450: {
                items: 4
            },
            768: {
                items: 5
            },
            1000: {
                items: 6
            }
        }
    });
});
</script>

<script>
$("#betRequestModal").on('hide', function() {
    window.location.reload();
});
</script>
<script>
$(document).ready(function() {
    var show_time = 'time';
    show_t(show_time);
    setInterval(function() {
        show_t(show_time);
    }, 1000);
});

function show_t(show_time) {
    $.ajax({
        url: "timestamp.php",
        method: "post",
        data: {
            show_time: show_time
        },
        success: function(data) {
            $('#timestamp').html(data);

        }
    })
}
</script>
<script>
$('#sel1').change(function() {
    document.getElementById("req-deposit-to").value = document.getElementById("sel1").value;
    var method_val = $('#sel1 option[value="' + $(this).val() + '"]').data('method');
    document.getElementById("method").value = method_val;
});
</script>
<script>
// $("#bet").on("change keypress input", function() {
//     $("#stake").value( $(this).val() );
//     var a=($(this).val()*2.37).toFixed(2);
//     $("#possible").innerHTML(a);

// });  

$("#bet").on("change keypress input", function() {
    var rate = $("#asshole").text();
    $('#stake').text(this.value);
    var as = document.getElementById("stake").value;
    document.getElementById("possible").style.display = "none";
    document.getElementById("poss").style.visibility = "visible";
    var as = ($('#stake').text() * rate).toFixed(2);
    $('#poss').text(as);
});
</script>

<script>
// function bet() {
// var  url = "bet.php";
// var type = "post";
// var  data="text";
// var res= url + type + data;
// document.getElementById('betRequestModalLabel').innerHTML;
// }

function bet(stack_id, game_id) {
    var tab = localStorage.getItem('tab');
    if (tab == 1) {
        localStorage.removeItem('gameIds');
        localStorage.removeItem('games');
        $.ajax({
            url: "bet.php",
            type: "post",
            dataType: "text",
            data: {
                stake_id: stack_id
            },
            success: function(a) {
                var respData1 = JSON.parse(a);
                if (respData1.fucker === 'Active') {
                    $('#error_data').html(respData1.error);
                    $('#first_data').html(respData1.first);
                    $('#second_data').html(respData1.second);
                    $('#possible').html(respData1.possible);
                    $('#asshole').html(respData1.possible1);
                    $('#button_data').html(respData1.button);
                    $('#betRequestModal').modal('show');
                    $('#possible').trigger('change');
                    $('#rate').trigger('change');
                    $('#betRequestModal').modal('show');
                } else {
                    location.reload();
                }
            }
        });
    }

    if (tab == 2) {

        var gamesArr = [];

        ax = JSON.parse(localStorage.getItem('games')) || [];
        var x = ax.find(element => element.game_id == game_id);

        var betLength = ax.length;
        $('#multi-bet-count-button').show();
        $('#countBet').html(betLength);

        if (x) {
            $('#existModal').modal('show');
        } else {
            $.ajax({
                url: "multi-bet.php",
                type: "post",
                dataType: "text",
                data: {
                    stake_id: stack_id
                },
                success: function(response) {
                    var res = JSON.parse(response);
                    var obj = {
                        game_id: res[0].game_id,
                        stake_id: res[0].stake_id,
                        desh1: res[0].desh1,
                        desh2: res[0].desh2,
                        tournament: res[0].tournament,
                        date: res[0].date,
                        time: res[0].time,
                        satke_name: res[0].stake_name,
                        bet_name: res[0].bet_name,
                        rate: res[0].rate
                    }
                    gamesArr = JSON.parse(localStorage.getItem('games')) || [];
                    gamesArr.push(obj);
                    localStorage.setItem('games', JSON.stringify(gamesArr));



                    var betLength = gamesArr.length;
                    $('#countBet').html(betLength);
                }
            });
        }




        
    }



}

$('#multi-bet-count-button').click(function() {
            $('#goMultiBet').hide();
            $('#betRequestModal').modal('show');

            var myArr = JSON.parse(localStorage.getItem('games')) || [];
            $.each(myArr, function(index, value) {
                $("#multi-bet-data").append(
                    "<ul>" +
                    "<li> " + value.desh1 + ' VS ' + value.desh2 + ' || ' + value.tournament +
                    ' || ' + value.date +
                    ' || ' + value.time + "</li>" +
                    "<li>" + value.satke_name + "</li>" +
                    "<li>" + value.bet_name + '<span class="rate">' + value.rate + '</span>' +
                    "</li>" +
                    "</ul>");
            });
        });



// Bet Modal
$(document).ready(function() {
    // Single Bet 
    localStorage.setItem('tab', 1);
    $('#single-bet-trigger').click(function() {
        $('#single-bet-trigger').addClass('current');
        $('#multi-bet-trigger').removeClass('current');
        $('#single-tab').addClass('current-tab');
        $('#multi-tab').removeClass('current-tab');

        localStorage.removeItem('gameIds');
        localStorage.setItem('tab', 1);
        $('#multi-bet-count-button').hide();
        $('#multi-bet-data').hide();
    });


    // Multi Bet
    $('#multi-bet-trigger').click(function() {
        $('#single-bet-trigger').removeClass('current');
        $('#multi-bet-trigger').addClass('current');
        $('#multi-tab').addClass('current-tab');
        $('#single-tab').removeClass('current-tab');

        localStorage.setItem('tab', 2);
        $('#goMultiBet').show();
    });

    $('#goMultiBet').click(function() {
        $('#betRequestModal').modal('hide');
    });

});
</script>
<script>
function betPost(bet_id) {

    var amount = $("#stake").text();
    $.ajax({
        url: "bet-post.php",
        type: "post",
        dataType: "text",
        data: {
            stake_id: bet_id,
            amount: amount
        },
        success: function(a) {
            var respData = JSON.parse(a);

            if (respData.fucker === 'Active') {
                $('#error_data').html(respData.error);
                $('#first_data').html(respData.first);
                $('#second_data').html(respData.second);
                $('#possible').html(respData.possible);
                $('#asshole').html(respData.possible1);
                $('#button_data').html(respData.button);
                $('#betRequestModal').modal('show');
                // $('#bet').trigger('change');
                $('#possible').trigger('change');
                $('#rate').trigger('change');
                $('#betRequestModal').modal('show');
            } else {
                location.reload();
            }
        }
    });

}
</script>

<script>
function depositPost() {
    var data = {
        sellist1: document.getElementById("method").value,
        to: document.getElementById("req-deposit-to").value,
        amount: document.getElementById("req-deposit-amount").value,
        from: document.getElementById("req-deposit-from").value,
        transection_number: document.getElementById("req-deposit-transaction_number").value
    }
    $.ajax({
        url: "deposit.php",
        type: "post",
        data: data,
        success: function(response) {
            $('#status_data').html(response);
        }
    })
}
</script>

<script>
function withdrawPost() {

    var withdraw_amount = document.getElementById("req-withdraw-amount").value;
    var withdraw_method = document.getElementById("withdraw_method").value;
    var withdraw_to = document.getElementById("req-withdraw-to").value;
    var account_type = document.getElementById("withdraw_account_type").value;

    $.ajax({
        url: "withdraw.php",
        type: "post",
        dataType: "text",
        data: {
            withdraw_method: withdraw_method,
            account_type: account_type,
            withdraw_to: withdraw_to,
            withdraw_amount: withdraw_amount
        },
        success: function(a) {
            var respData3 = JSON.parse(a);
            $('#status_data1').html(respData3.wstatues);
            $('#requestWithdrawModal').modal('show');
        }
    });

}
</script>
<script>
$('.list-item').click(function() {
    $('.list-item').removeClass('active');
    $(this).addClass('active');
    $('.bhoechie-tab').addClass('hide');
    $($(this).attr('href')).removeClass('hide');
});
</script>

<script>
function showMessage(data) {
    $(this).find('[type="submit"]').prop('disabled', false);
    var output = '';
    var type = 'error';
    if (data['status'] == true) {
        output = output + "<li>" + data['message'] + "</li>";
        type = 'success';
        // setTimeout(function () {
        //     $('.modal').modal('hide');
        // }, 2000);
        // $('#placeBet').prop('disabled',false);
    } else if (data['status'] == false) {
        $('[type="submit"]').prop('disabled', false).removeClass('loader');;
        output = output + "<li>" + data['message'] + "</li>";
    } else if (data['status'] === 422) {
        $('[type="submit"]').prop('disabled', false).removeClass('loader');;
        var errors = data['responseJSON']['errors'];
        output = getValidationError(errors);
    } else if (typeof data['responseJSON']['error'] !== 'undefined') {
        $('[type="submit"]').prop('disabled', false).removeClass('loader');;
        output = '<li>' + data['responseJSON']['error'] + '</li>';
    } else {
        $('[type="submit"]').prop('disabled', false).removeClass('loader');;
        output = '<li>' + data['responseJSON']['message'] + '</li>';
    }

    alertAjaxMessage(type, output);
}

$('#all').on('click', function() {
    $('.Football').show();
    $('.Cricket').show();
    $('.Basketball').show();
    $('.Badminton').show();
    $('.Tennis').show();
    $('.vball').show();
    $('.Handball').show();
    $('.Hockey').show();
    $('.Virtual Game').show();
});
$('#Cricket').on('click', function() {
    $('.Football').hide();
    $('.Cricket').show();
    $('.Basketball').hide();
    $('.Badminton').hide();
    $('.Tennis').hide();
    $('.vball').hide();
    $('.Handball').hide();
    $('.Hockey').hide();
    $('.Virtual Game').hide();
});
$('#Football').on('click', function() {
    $('.Football').show();
    $('.Cricket').hide();
    $('.Basketball').hide();
    $('.Badminton').hide();
    $('.Tennis').hide();
    $('.vball').hide();
    $('.Handball').hide();
    $('.Hockey').hide();
    $('.Virtual Game').hide();
});
$('#Basketball').on('click', function() {
    $('.Football').hide();
    $('.Cricket').hide();
    $('.Basketball').show();
    $('.Badminton').hide();
    $('.Tennis').hide();
    $('.vball').hide();
    $('.Handball').hide();
    $('.Hockey').hide();
    $('.Virtual Game').hide();
});
$('#Badminton').on('click', function() {
    $('.Football').hide();
    $('.Cricket').hide();
    $('.Badminton').show();
    $('.Tennis').hide();
    $('.vball').hide();
    $('.Basketball').hide();
    $('.Handball').hide();
    $('.Hockey').hide();
    $('.Virtual Game').hide();
});
$('#Tennis').on('click', function() {
    $('.Football').hide();
    $('.Cricket').hide();
    $('.Badminton').hide();
    $('.Tennis').show();
    $('.vball').hide();
    $('.Basketball').hide();
    $('.Handball').hide();
    $('.Hockey').hide();
    $('.Virtual Game').hide();
});
$('#vball').on('click', function() {
    $('.Football').hide();
    $('.Cricket').hide();
    $('.Badminton').hide();
    $('.Tennis').hide();
    $('.vball').show();
    $('.Basketball').hide();
    $('.Handball').hide();
    $('.Hockey').hide();
    $('.Virtual Game').hide();
});
$('#Handball').on('click', function() {
    $('.Football').hide();
    $('.Cricket').hide();
    $('.Badminton').hide();
    $('.Tennis').hide();
    $('.vball').hide();
    $('.Basketball').hide();
    $('.Handball').show();
    $('.Hockey').hide();
    $('.Virtual Game').hide();
});
$('#Hockey').on('click', function() {
    $('.Football').hide();
    $('.Cricket').hide();
    $('.Badminton').hide();
    $('.Tennis').hide();
    $('.vball').hide();
    $('.Basketball').hide();
    $('.Handball').hide();
    $('.Hockey').show();
    $('.Virtual Game').hide();
});
$('#Virtual Game').on('click', function() {
    $('.Football').hide();
    $('.Cricket').hide();
    $('.Badminton').hide();
    $('.Tennis').hide();
    $('.vball').hide();
    $('.Basketball').hide();
    $('.Handball').hide();
    $('.Hockey').hide();
    $('.Virtual Game').show();
});
</script>

<!-- Balance Transfer  -->
<script>
$(document).ready(function() {
    $('.select2').select2();
    $('#submit').click(function(e) {
        e.preventDefault();

        var data = {
            sender: $('#sender').val(),
            reciver: $('#reciver').val(),
            amount: $('#amount').val()
        }

        $.ajax({
            url: "balance-transfer.php",
            type: "post",
            data: data,
            success: function(a) {
                var response = JSON.parse(a);

                if (response.low) {
                    $('#transfer_status').html(response.low);
                }
                if (response.sucess) {
                    $('#transfer_status').html(response.sucess);
                }
            }
        });
    })
});
</script>
</body>

</html>