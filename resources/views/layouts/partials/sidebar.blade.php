<!--**********************************
    Sidebar start
***********************************-->
<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label first">Main Menu</li>
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="icon icon-single-04"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon icon-layout-25"></i>
                    <span class="nav-text">Master Data</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('kategori') }}">Kategori</a></li>
                    <li><a href="{{ route('satuan') }}">Satuan</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('barang') }}">
                    <i class="icon icon-app-store"></i>
                    <span class="nav-text">Data Barang</span>
                </a>
            </li>
            <li>
                <a href="{{ route('aksesoris') }}">
                    <i class="icon icon-app-store"></i>
                    <span class="nav-text">Data Aksesoris</span>
                </a>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon icon-cart-9"></i>
                    <span class="nav-text">Pembelian</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('pembelian.barang') }}">Barang</a></li>
                    <li><a href="{{ route('pembelian.aksesoris') }}">Aksesoris</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="icon icon-send"></i>
                    <span class="nav-text">Penjualan</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('penjualan.barang') }}">Barang</a></li>
                    <li><a href="{{ route('penjualan.aksesoris') }}">Aksesoris</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ route('penyewaan') }}">
                    <i class="icon icon-form"></i>
                    <span class="nav-text">Penyewaan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('suratjalan') }}">
                    <i class="icon icon-book-open-2"></i>
                    <span class="nav-text">Surat Jalan</span>
                </a>
            </li>
            
            @if(Auth::user()->level <> 'Operator')
                
            <li class="nav-label first">Setting</li>
            <li>
                <a href="{{ route('setting') }}">
                    <i class="icon icon-settings"></i>
                    <span class="nav-text">Setting Website</span>
                </a>
            </li>
            
            @endif

            <li class="nav-label first">Management User</li>
            <li>
                <a href="{{ route('user') }}">
                    <i class="fa fa-users"></i>
                    <span class="nav-text">Users</span>
                </a>
            </li>

            <li>
                <a href="{{ route('logout') }}">
                    <i class="icon-key"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </li>

        </ul>
    </div>


</div>
<!--**********************************
    Sidebar end
***********************************-->
