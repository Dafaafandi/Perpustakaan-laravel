<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>
    <h3>Selamat Datang di Perpustakaan Lamongan YEAYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYYY</h3>
    <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">
        <p>
            <a href="/kategori" :active="request()->is('kategori')">
                <img src="https://cdn-icons-png.flaticon.com/512/3767/3767084.png"
                    alt="Your Company" class="size-8" />
                Category
            </a>
        </p>
        <p>
            <a href="/buku" :active="request()->is('buku')">
                <img src="https://media.istockphoto.com/id/1393398776/id/vektor/tumpukan-ikon-buku-hardcover-berwarna-warni-simbol-membaca.jpg?s=170667a&w=0&k=20&c=BO8PY1YphHnOSe_Vqlsyh8GBfj4ToM38CVMowk-AnT0="
                    alt="Your Company" class="size-8" />
                Book
            </a>
        </p>
        <p>
            <a href="/peminjaman" :active="request()->is('peminjaman')">
                <img src="https://media.istockphoto.com/id/1281124744/id/vektor/laptop-dengan-ilustrasi-ikon-checklist-atau-clipboard-ikon-survei-online.jpg?s=170667a&w=0&k=20&c=tGb3Fv1B2ZwwaqlEfVPep8FVDb2OPWpEiI1B6estfMo="
                    alt="Your Company" class="size-8" />
                Borrowing
            </a>
        </p>
        <p>
            <a href="/daftar" :active="request()->is('daftar')">
                <img src="https://static.vecteezy.com/system/resources/previews/000/550/535/original/user-icon-vector.jpg"
                    alt="Your Company" class="size-8" />
                Member List
            </a>
        </p>
    </div>
</x-layout>
