document.addEventListener("DOMContentLoaded", function() {
    let dateSelector = document.getElementById("dateSelector");
    let monthSelector = document.getElementById("monthSelector");
    let showScheduleButton = document.getElementById("showScheduleButton");
    let tables = document.querySelectorAll(".schedule-table");

    // Array konversi bulan & hari ke bahasa Indonesia
    const bulanIndonesia = {
        "January": "Januari",
        "February": "Februari",
        "March": "Maret",
        "April": "April",
        "May": "Mei",
        "June": "Juni",
        "July": "Juli",
        "August": "Agustus",
        "September": "September",
        "October": "Oktober",
        "November": "November",
        "December": "Desember"
    };

    const hariIndonesia = {
        "Sunday": "Minggu",
        "Monday": "Senin",
        "Tuesday": "Selasa",
        "Wednesday": "Rabu",
        "Thursday": "Kamis",
        "Friday": "Jumat",
        "Saturday": "Sabtu"
    };

    // Fungsi untuk menerjemahkan tanggal pada semua elemen dengan kelas schedule-table
    function translateDates() {
        document.querySelectorAll(".schedule-table h5").forEach(el => {
            let text = el.innerText;
            Object.keys(hariIndonesia).forEach(hari => {
                text = text.replace(hari, hariIndonesia[hari]);
            });
            Object.keys(bulanIndonesia).forEach(bulan => {
                text = text.replace(bulan, bulanIndonesia[bulan]);
            });
            el.innerText = text;
        });
    }

    function showSelectedTable() {
        let selectedId = dateSelector.value;

        tables.forEach(table => {
            table.style.display = (table.id === selectedId) ? "block" : "none";
        });
    }

    function filterDatesByMonth() {
        let selectedMonth = monthSelector.value;
        let options = dateSelector.options;

        for (let i = 0; i < options.length; i++) {
            let option = options[i];
            let optionMonth = option.getAttribute("data-month");

            if (selectedMonth === "" || optionMonth === selectedMonth) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        }

        for (let i = 0; i < options.length; i++) {
            if (options[i].style.display === "block") {
                dateSelector.value = options[i].value;
                break;
            }
        }

        showSelectedTable();
    }

    // Event Listener
    if (monthSelector) {
        monthSelector.addEventListener("change", filterDatesByMonth);
    }

    if (showScheduleButton) {
        showScheduleButton.addEventListener("click", showSelectedTable);
    }

    // **Panggil fungsi saat halaman pertama kali dimuat**
    if (monthSelector) {
        filterDatesByMonth();
    }

    translateDates();
});
