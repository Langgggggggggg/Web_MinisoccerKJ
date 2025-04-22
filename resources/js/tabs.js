function showTab(status) {
    // Menangani perubahan tab
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('bg-emerald-500', 'text-white');
        button.classList.add('bg-gray-100', 'text-gray-600');
    });

    const tabButton = document.getElementById('tab' + status.charAt(0).toUpperCase() + status.slice(1));
    if (tabButton) {
        tabButton.classList.add('bg-emerald-500', 'text-white');
        tabButton.classList.remove('bg-gray-100', 'text-gray-600');
    }

    // Menyembunyikan semua baris terlebih dahulu
    document.querySelectorAll('tbody tr').forEach(row => {
        row.style.display = 'none';
    });

    // Menampilkan baris yang sesuai dengan status tab
    document.querySelectorAll('.' + status).forEach(row => {
        row.style.display = '';
    });

    // Menampilkan atau menyembunyikan kolom "Aksi"
    const aksiHeader = document.getElementById('aksiHeader');
    const aksiColumns = document.querySelectorAll('.aksiColumn');

    if (status === 'belumLunas') {
        if (aksiHeader) aksiHeader.style.display = '';
        aksiColumns.forEach(cell => cell.style.display = '');
    } else {
        if (aksiHeader) aksiHeader.style.display = 'none';
        aksiColumns.forEach(cell => cell.style.display = 'none');
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const tableContent = document.getElementById('tableContent');

    if (tableContent) {
        tableContent.classList.remove('hidden');
        showTab('belumLunas');

        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', event => {
                const status = event.target.getAttribute('data-status');
                showTab(status);
            });
        });
    }
});


// Fungsi pencarian
const searchInput = document.getElementById("searchInput");
if (searchInput) {
    searchInput.addEventListener("input", function() {
    let searchValue = this.value.toLowerCase().trim();
    let allRows = document.querySelectorAll("tbody tr");

    // Menentukan tab yang sedang aktif
    let activeTab = document.querySelector(".tab.active");
    let activeTabId = activeTab ? activeTab.id : "tabBelumLunas";
    let activeStatus = activeTabId === "tabLunas" ? "lunas" : "belumLunas";

    let foundInBelumLunas = false;
    let foundInLunas = false;

    // Menyaring baris berdasarkan pencarian
    allRows.forEach(row => {
        let kodePemesanan = row.cells[0]?.innerText.toLowerCase();
        let namaTim = row.cells[1]?.innerText.toLowerCase();
        let status = row.classList.contains("lunas") ? "lunas" : "belumLunas";

        if (kodePemesanan.includes(searchValue) || namaTim.includes(searchValue)) {
            if (status === "lunas") {
                foundInLunas = true;
            } else {
                foundInBelumLunas = true;
            }
        }
    });

    // Jika input kosong, tampilkan tab "Belum Lunas" dan hanya data yang sesuai
    if (searchValue === "") {
        showTab("belumLunas"); // Pindah ke tab "Belum Lunas"
        allRows.forEach(row => {
            let status = row.classList.contains("lunas") ? "lunas" : "belumLunas";
            row.style.display = (status === "belumLunas") ? "" : "none";
        });
        return;
    }

    // Menentukan tab berdasarkan hasil pencarian
    if (foundInLunas) {
        showTab("lunas");
    } else if (foundInBelumLunas) {
        showTab("belumLunas");
    }

    // Menyaring hasil pencarian dan menampilkan baris yang sesuai
    allRows.forEach(row => {
        let kodePemesanan = row.cells[0]?.innerText.toLowerCase();
        let namaTim = row.cells[1]?.innerText.toLowerCase();
        let status = row.classList.contains("lunas") ? "lunas" : "belumLunas";

        if ((kodePemesanan.includes(searchValue) || namaTim.includes(searchValue)) &&
            ((foundInLunas && status === "lunas") || (foundInBelumLunas && status === "belumLunas"))
        ) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});
}
