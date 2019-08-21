$(document).ready(function () {
    // JS UNTUK MENAMPILKAN WAKTU REALTIME
    var dayNames = ['Minggu','Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    
    var monthNames = ["Januari", "February", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
        ];


    var updateClock = function () {
        function pad(n) {
            return (n < 10) ? '0' + n : n;
        }

        var now = new Date();
        
        var s = 
                pad(dayNames[now.getDay()]) + ', ' +
                pad(now.getDate()) + ' ' +
                pad(monthNames[now.getMonth()]) + ' ' +
                pad(now.getFullYear()) + ' | ' +
                pad(now.getHours()) + ':' +
                pad(now.getMinutes()) + ':' +
                pad(now.getSeconds());

        $('#waktu').html(s);

        var delay = 1000 - (now % 1000);
        setTimeout(updateClock, delay);
    };
    updateClock();
    // End JS Menampilkan Waktu

    // JS Untuk mengatur news content slider
    $("#news-slider").owlCarousel({
        items : 2,
        itemsDesktop : [1199,2],
        itemsMobile : [600,1],
        pagination :true,
        autoPlay : true
    });
    // End JS Untuk mengatur news content slider

    

});