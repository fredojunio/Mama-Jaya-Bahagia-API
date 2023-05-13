<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Item;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        $user = new User();
        $user->name = "Angelia";
        $user->email = "angeliaveronikaa@gmail.com";
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make('martda1403');
        $user->role_id = 1;
        $user->save();

        $user = new User();
        $user->name = "Meiling";
        $user->email = "meiling.lidyaa@gmail.com";
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make('meli1305');
        $user->role_id = 1;
        $user->save();

        $user = new User();
        $user->name = "Owner 1";
        $user->email = "owner1@gmail.com";
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make('MAMAJAYA');
        $user->role_id = 1;
        $user->save();

        $user = new User();
        $user->name = "Owner 2 ";
        $user->email = "owner2@gmail.com";
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make('MJBAHAGIA');
        $user->role_id = 1;
        $user->save();

        $user = new User();
        $user->name = "Admin Pusat";
        $user->email = "admin1@gmail.com";
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make('admin123');
        $user->role_id = 2;
        $user->save();

        $user = new User();
        $user->name = "Admin Cabang";
        $user->email = "admin2@gmail.com";
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make('admin456');
        $user->role_id = 2;
        $user->save();

        $user = new User();
        $user->name = "Admin 3";
        $user->email = "admin3@gmail.com";
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make('admin789');
        $user->role_id = 2;
        $user->save();

        $user = new User();
        $user->name = "Finance";
        $user->email = "Finance1@gmail.com";
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make('fine321');
        $user->role_id = 3;
        $user->save();

        $user = new User();
        $user->name = "Finance 2";
        $user->email = "Finance2@gmail.com";
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make('fine654');
        $user->role_id = 3;
        $user->save();

        $user = new User();
        $user->name = "Finance";
        $user->email = "Finance3@gmail.com";
        $user->email_verified_at = Carbon::now();
        $user->password = Hash::make('fine987');
        $user->role_id = 3;
        $user->save();

        $role = new Customer();
        $role->nik = "3525151608720001";
        $role->name = "Abd Halim";
        $role->nickname = "HALIM CANGKIR";
        $role->address = "Dsn. Wates RT 10/RW 06, Cangkir- Driyorejo";
        $role->phone = "08123123123";
        $role->ongkir = 2000;
        $role->birthdate = "1972-08-16";
        $role->type = "Kiriman";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3503051902860000";
        $role->name = "Achmad Tohari";
        $role->nickname = "AHMAD";
        $role->address = "Dsn. Krajan RT 12/ RW 03, Nglongsor - Tugu";
        $role->phone = "08123123123";
        $role->birthdate = "1986-02-19";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3515140606610001";
        $role->name = "Achmad Misbachul Munir";
        $role->nickname = "MUNIR";
        $role->address = "Masangan Kulon RT 01 / RW 01, Sukodono";
        $role->phone = "08123123123";
        $role->birthdate = "1961-06-06";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130607800007";
        $role->name = "Aeidul Kohar";
        $role->nickname = "KOHAR";
        $role->address = "Kedungboto RT 18 / RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1980-07-06";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3578172702850002";
        $role->name = "Adi Purwanto";
        $role->nickname = "HALIM";
        $role->address = "Tanah Merah Indah Syur 6/7 RT 24/ RW 04, Tanah Kali Kedinding";
        $role->phone = "08123123123";
        $role->birthdate = "1985-02-27";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3526131808820005";
        $role->name = "Agus Priyanto";
        $role->nickname = "KIPLI TAHU";
        $role->address = "Kedungboto RT 17 / RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1982-08-18";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3518041011860003";
        $role->name = "Agus Sutamaji";
        $role->nickname = "AJI YAYAK";
        $role->address = "Dsn. Krembangan RT 03 / RW 01, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1986-11-10";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3515141309740001";
        $role->name = "Agustinus";
        $role->nickname = "AGUS JINGGO";
        $role->address = "Legok RT 16 / RW 06, Sukodono";
        $role->phone = "08123123123";
        $role->birthdate = "1974-09-13";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3505211708750002";
        $role->name = "Agus Tono";
        $role->nickname = "AGUS VEGA";
        $role->address = "Dsn. Sadang RT 01/RW 01, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1975-08-17";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515131911780006";
        $role->name = "Aji Parminardi";
        $role->nickname = "DIDIK TAHU";
        $role->address = "Dsn. Sambisari RT 26/RW 05, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1978-11-19";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3577031005790004";
        $role->name = "Alfin Ariyanto";
        $role->nickname = "ALPIN";
        $role->address = "Jelok RT 03/ RW 02, Kayen- Pacitan";
        $role->phone = "08123123123";
        $role->birthdate = "1979-05-10";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3326192205940001";
        $role->name = "Amat Marulah";
        $role->nickname = "MARUL";
        $role->address = "Dk. Werdi Tengah RT 10/ RW 05, Wonokerto";
        $role->phone = "08123123123";
        $role->birthdate = "1994-05-22";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3506032402750001";
        $role->name = "Andis Dwi Suranto";
        $role->nickname = "DWI";
        $role->address = "Dsn. Kevling Kalibader RT 21/ RW 03, Taman ";
        $role->phone = "08123123123";
        $role->birthdate = "1975-02-24";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();
        $role = new Customer();
        $role->nik = "3515132512870002";
        $role->name = "Andi Nasir";
        $role->nickname = "ANDI TAHU";
        $role->address = "Taman RT 17/RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1987-12-25";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3578203010860001";
        $role->name = "Andi Yulefi";
        $role->nickname = "ANDI WIYUNG";
        $role->address = "Wiyung RT 02/ RW 06";
        $role->phone = "08123123123";
        $role->birthdate = "1986-10-30";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3525131406800001";
        $role->name = "Arik Masrufi";
        $role->nickname = "ARIK MENGANTI";
        $role->address = "Menganti RT 03/ RW 02 ";
        $role->phone = "08123123123";
        $role->ongkir = 2000;
        $role->birthdate = "1980-06-14";
        $role->type = "Kiriman";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3525156012670001";
        $role->name = "Arnasih";
        $role->nickname = "ARNASIH";
        $role->address = "Dsn. Lopang RT 01/ RW 04, Driyorejo";
        $role->phone = "08123123123";
        $role->birthdate = "1967-12-06";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3525154104740003";
        $role->name = "Aseh";
        $role->nickname = "BU ASIH";
        $role->address = "Jl. Merapi RT 07/ RW 02, Bambe- Driyorejo";
        $role->phone = "08123123123";
        $role->birthdate = "1974-04-14";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3515132411710005";
        $role->name = "Astoi";
        $role->nickname = "TOIN";
        $role->address = "Jl. Sawunggaling I RT 15/ RW 03, Jemundo - Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1971-11-24";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3328162881830021";
        $role->name = "Bakir";
        $role->nickname = "BAKRI JUANDA";
        $role->address = "Bondansari RT 06/ RW 03, Wiradesa";
        $role->phone = "08123123123";
        $role->ongkir = 2000;

        $role->birthdate = "1971-11-24";
        $role->type = "Kiriman";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3326161306750001";
        $role->name = "Bambang Junaedi";
        $role->nickname = "JUNED";
        $role->address = "Bondansari RT 06/ RW 03, Wiradesa";
        $role->phone = "08123123123";
        $role->birthdate = "1975-06-13";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515132303720009";
        $role->name = "Basuki";
        $role->nickname = "ABAS";
        $role->address = "Taman Barat RT 01/ RW 01, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1972-03-23";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3515130210900005";
        $role->name = "Bayu Aditama";
        $role->nickname = "BAYU";
        $role->address = "Kedungboto RT 17/ RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1990-10-02";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3506171508670006";
        $role->name = "Budiaji";
        $role->nickname = "PAK JI AFIF";
        $role->address = "Jl. Bintan 2 RT 01/ RW 10, Palem - Pare";
        $role->phone = "08123123123";
        $role->birthdate = "1967-08-15";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3326083006650006";
        $role->name = "Casirin";
        $role->nickname = "BIRIN";
        $role->address = "Jl. Ubi 1 RT 01/ RW 10, Wage -  Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1965-06-30";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130304680005";
        $role->name = "Dadan Suryanda";
        $role->nickname = "DADAN";
        $role->address = "Taman RT 17/ RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1968-04-03";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3326171903780001";
        $role->name = "Dama";
        $role->nickname = "DAMAK";
        $role->address = "Jl. Bagus Santri RT 04/ RW 02, Bohar- Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1978-03-19";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515134102770001";
        $role->name = "Dewi Wahyuni";
        $role->nickname = "KHOLIS";
        $role->address = "Taman RT 17/ RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1977-02-14";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130607550001";
        $role->name = "Djunaidi";
        $role->nickname = "ZUNAIDI";
        $role->address = "Dsn. Sambisari RT 29/ RW 05, Sambibulu - Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1955-07-06";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3326172503920004";
        $role->name = "Doni Setiawan";
        $role->nickname = "DONI";
        $role->address = "Dsn. Boyoteluk 3 RT 02/ RW 06, Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1992-03-25";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3578240712680003";
        $role->name = "Dowo Wibowo";
        $role->nickname = "WIBOWO";
        $role->address = "Tenggilis Lama 4-A/12 RT 07/ RW 04, Tenggilis Mejoyo";
        $role->phone = "08123123123";
        $role->birthdate = "1968-12-07";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3326161507870043";
        $role->name = "Edi Pramono";
        $role->nickname = "PRAMONO";
        $role->address = "Pekuncen RT 03/ RW 07, Wiradesa";
        $role->phone = "08123123123";
        $role->birthdate = "1987-07-15";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3326170906960001";
        $role->name = "Edi Purwanto";
        $role->nickname = "ANTOK";
        $role->address = "Dk. Cangkring Kulon RT 01/ RW 08, Tengengwetan - Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1996-06-09";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3326193001750006";
        $role->name = "Edi Waluyo";
        $role->nickname = "WALUYO";
        $role->address = "Dk. Keludan RT 02/ RW 01, Werdi- Wonokerto";
        $role->phone = "08123123123";
        $role->birthdate = "1975-01-30";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3515131909820007";
        $role->name = "EKO ADI W";
        $role->nickname = "ADI ABI";
        $role->address = "Kedungboto RT 17/ RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1982-09-19";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3515131010690016";
        $role->name = "Elijas Boediono";
        $role->nickname = "PAK YAS";
        $role->address = "Sambisari Perintis 4 RT 36/ RW 07, Taman";
        $role->phone = "08123123123";
        $role->ongkir = 2000;
        $role->birthdate = "1969-10-10";
        $role->type = "Kiriman";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3518121111890002";
        $role->name = "Erma Purnama ";
        $role->nickname = "KLIWON";
        $role->address = "Kemlaten 8/24 RT 01/ RW 06, Kebraon - Karangpilang";
        $role->phone = "08123123123";
        $role->birthdate = "1989-11-11";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3211171202700009";
        $role->name = "Eman Sulaeman";
        $role->nickname = "EMAN";
        $role->address = "Dsn. Sukamulya RT 05/ RW 01, Gunungsari";
        $role->phone = "08123123123";
        $role->birthdate = "1970-02-12";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3515146811750001";
        $role->name = "Erniatin";
        $role->nickname = "MBAK TIN";
        $role->address = "Saimbang RT 13/ RW 04, Kebon Agung- Sukodono";
        $role->phone = "08123123123";
        $role->ongkir = 2000;
        $role->birthdate = "1975-11-28";
        $role->type = "Kiriman";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515135906710001";
        $role->name = "Ernamawati, S.PD.";
        $role->nickname = "ERNA";
        $role->address = "Jl. Sawunggaling 1 RT 15/ RW 02, Jemundo -  Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1971-06-19";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3515140601800001";
        $role->name = "Giyanto";
        $role->nickname = "GIANTO";
        $role->address = "Sukolegok RT 16 / RW 06, Sukodono";
        $role->phone = "08123123123";
        $role->birthdate = "1980-01-06";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3326171709950002";
        $role->name = "Gunawan";
        $role->nickname = "GUNAWAN TOMPEL";
        $role->address = "Dk. Blimbing Lor RT 02/ RW 02, Blimbing Wuluh - Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1995-09-17";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();



        $role = new Customer();
        $role->nik = "3515130711670001";
        $role->name = "H. Nur. Kholiq";
        $role->nickname = "H. KHOLIK";
        $role->address = "Geluran RT 11/ RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1967-11-07";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3326171507900001";
        $role->name = "Hadi Kurniawan";
        $role->nickname = "ADI AJAY";
        $role->address = "Wonosari RT 02/ RW 04, Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1990-07-15";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3326101507860002";
        $role->name = "Haryanto";
        $role->nickname = "HARR";
        $role->address = "Dukuh Sawi RT 02/ RW 07, Klunjukan - Sragi";
        $role->phone = "08123123123";
        $role->birthdate = "1986-07-15";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3578241206900001";
        $role->name = "Heri Setiyono";
        $role->nickname = "HERI SERUNI";
        $role->address = "Dsn. Ngudi RT 02/ RW 04, Punggul - Gedangan";
        $role->phone = "08123123123";
        $role->ongkir = 2000;
        $role->birthdate = "1990-06-12";
        $role->type = "Kiriman";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515142012790001";
        $role->name = "Imam Afandi";
        $role->nickname = "IMAM";
        $role->address = "Sukodono RT 05/ RW 01";
        $role->phone = "08123123123";
        $role->birthdate = "1979-12-20";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3515144710740002";
        $role->name = "Iin Sugiarini";
        $role->nickname = "IIN";
        $role->address = "Saimbang RT 14/ RW 04, Kebon Agung - Sukodono";
        $role->phone = "08123123123";
        $role->ongkir = 2000;
        $role->birthdate = "1974-10-07";
        $role->type = "Kiriman";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();



        $role = new Customer();
        $role->nik = "3515131004730001";
        $role->name = "Imam Rokhmad";
        $role->nickname = "TOTOK";
        $role->address = "Dsn. Sambibulu RT 04/ RW 01, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1973-04-10";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();



        $role = new Customer();
        $role->nik = "3505152404930001";
        $role->name = "Indra Kurniawan";
        $role->nickname = "INDRA PAIJO";
        $role->address = "Terik RT 13 / RW 06, Krian";
        $role->phone = "08123123123";
        $role->birthdate = "1993-04-24";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3517081012840007";
        $role->name = "Irwan";
        $role->nickname = "WAWAN A";
        $role->address = "Dsn. Watugaluh RT 01/ RW 02";
        $role->phone = "08123123123";
        $role->birthdate = "1984-12-10";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515131507590002";
        $role->name = "Jemakir";
        $role->nickname = "BAKIR";
        $role->address = "Dsn. Sambisaei Kav. Selatan blok E-13, Sambibulu- Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1959-07-15";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3525132111840002";
        $role->name = "Joko Suhendro";
        $role->nickname = "HENDRA MENGANTI";
        $role->address = "Peniron Kulon RT 02/ RW 01, Gading- Watu- Menganti";
        $role->phone = "08123123123";
        $role->ongkir = 2000;
        $role->birthdate = "1984-11-21";
        $role->type = "Kiriman";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3578010605860002";
        $role->name = "Joko Vitono";
        $role->nickname = "JOKO TAHU";
        $role->address = "Kemlaten 10/2 RT 03/ RW 06, Kebraon – Karangpilang";
        $role->phone = "08123123123";
        $role->birthdate = "1986-05-06";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3515130501790007";
        $role->name = "Joni Winarno Hadi W";
        $role->nickname = "JONI";
        $role->address = "Taman RT 18/ RW 03, Taman- Sidoarjo";
        $role->phone = "08123123123";
        $role->birthdate = "1979-01-05";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3515132101680004";
        $role->name = "Kusyono";
        $role->nickname = "AGUS K";
        $role->address = "Jl. Nanas RT 10/ RW 03, Geluran - Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1968-01-21";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3327012105770005";
        $role->name = "Kasturi";
        $role->nickname = "KASTURI";
        $role->address = "Krajan 1 Wangkelang RT 02/ RW 01, Moga";
        $role->phone = "08123123123";
        $role->birthdate = "1977-05-21";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515136409800002";
        $role->name = "Kartini";
        $role->nickname = "BU TINI";
        $role->address = "Jl. Ubi 2 Margomulyo RT 04/ RW 10, Wage - Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1980-09-24";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3326162909850001";
        $role->name = "Kisbandi";
        $role->nickname = "KISBANDI";
        $role->address = "Werdi RT 17/ RW 08, Wonokerto";
        $role->phone = "08123123123";
        $role->birthdate = "1985-09-29";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3326190407920003";
        $role->name = "Kinto Surono";
        $role->nickname = "KINTO";
        $role->address = "Dsn. Dukuh RT 08/ RW 03, Bangsri – Sukodono ";
        $role->phone = "08123123123";
        $role->ongkir = 2000;
        $role->birthdate = "1992-07-04";
        $role->type = "Kiriman";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3505101210820004";
        $role->name = "Kodofir";
        $role->nickname = "DOFIR";
        $role->address = "Dsn. Munggalan RT 08/ RW 05, Karangsono- Kanigaro";
        $role->phone = "08123123123";
        $role->birthdate = "1982-10-12";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3578241210770007";
        $role->name = "Lestoro";
        $role->nickname = "TORO KEDURUS";
        $role->address = "Tenggilis Lama 3 Gang Longgar RT 05/ RW 05, Tenggilis Mejoyo";
        $role->phone = "08123123123";
        $role->ongkir = 2000;
        $role->birthdate = "1977-10-12";
        $role->type = "Kiriman";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515135305840002";
        $role->name = "Lia Fanani";
        $role->nickname = "RIDHO";
        $role->address = "Sambisari RT 31/ RW 06";
        $role->phone = "08123123123";
        $role->birthdate = "1984-05-13";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130105830008";
        $role->name = "M. Yusuf";
        $role->nickname = "YUSUF ANDIK";
        $role->address = "Banjarsari RT 08 /RW 03, Pertapaan – Maduretno Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1983-05-01";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3308162811840001";
        $role->name = "Mahmudi ";
        $role->nickname = "MAHMUDI";
        $role->address = "Dsn. Mulung RT 07/ RW 04, Driyorejo";
        $role->phone = "08123123123";
        $role->birthdate = "1984-11-28";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515132205990004";
        $role->name = "Mas Afif";
        $role->nickname = "AFIF";
        $role->address = "Dsn. Tanjunganom RT 11/ RW 01, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1999-05-22";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3517110103660008";
        $role->name = "Minto";
        $role->nickname = "MINTO";
        $role->address = "Dsn. Buduran RT 03/ RW 02, Jogoloyo";
        $role->phone = "08123123123";
        $role->birthdate = "1966-03-01";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130206630006";
        $role->name = "Moch. Jimba Sunoto";
        $role->nickname = "JIMBA";
        $role->address = "Taman RT 15/ RW 03";
        $role->phone = "08123123123";
        $role->birthdate = "1963-06-02";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515110610900003";
        $role->name = "Much. Fadelul";
        $role->nickname = "FADELI";
        $role->address = "Jenek Wetan RT 14/ RW 03, Krembangan- Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1990-10-06";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515132207600002";
        $role->name = "Mugiono";
        $role->nickname = "GOCO";
        $role->address = "Taman RT 17/ RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1960-07-22";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3525151604700002";
        $role->name = "Moh. Irfan Shodiq";
        $role->nickname = "IRFAN TENARU";
        $role->address = "Tenaru RT 03/ RW 01, Driyorejo";
        $role->phone = "08123123123";
        $role->ongkir = 2000;
        $role->birthdate = "1970-04-16";
        $role->type = "Kiriman";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3518122904930002";
        $role->name = "Muh. Kamat Yajib";
        $role->nickname = "YAJIB";
        $role->address = "Dsn. Cangak RT 01/ RW 05, Krandang";
        $role->phone = "08123123123";
        $role->birthdate = "1993-04-29";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3326171506900002";
        $role->name = "Muhammad Roni";
        $role->nickname = "RONI";
        $role->address = "Dk. Saren RT 02/ RW 06, Blimbing Wuluh- Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1990-06-15";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3326172610910002";
        $role->name = "Muhammad Wahyu";
        $role->nickname = "WAHYU";
        $role->address = "Dk. Gemusuh RT 02/ RW 05, Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1991-10-26";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3525157006650110";
        $role->name = "Murtini";
        $role->nickname = "KARSAN";
        $role->address = "Dsn. Lopang RT 01/ RW 04, Driyorejo";
        $role->phone = "08123123123";
        $role->ongkir = 2000;
        $role->birthdate = "1965-06-30";
        $role->type = "Kiriman";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515131110670004";
        $role->name = "Muslikin";
        $role->nickname = "LIKIN";
        $role->address = "Sambisari RT 34/ RW 07, Sambibulu -  Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1990-10-06";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130512720018";
        $role->name = "Moh. Juwari";
        $role->nickname = "JUHARI";
        $role->address = "Sadang Taman RT 02/ RW 01";
        $role->phone = "08123123123";
        $role->birthdate = "1972-12-05";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3506202707730004";
        $role->name = "Moh. Mustakim";
        $role->nickname = "TAKIM";
        $role->address = "Dsn. Krembangan RT 02/ RW 01, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1973-07-27";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515071107870009";
        $role->name = "Moh. Nurwahyudi";
        $role->nickname = "MAS YUDI";
        $role->address = "Sepande RT 07/ RW 02, Candi - Sidoarjo";
        $role->phone = "08123123123";
        $role->birthdate = "1987-07-11";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();


        $role = new Customer();
        $role->nik = "3524162412810001";
        $role->name = "Muhajirin";
        $role->nickname = "MUHAJIRIN";
        $role->address = "Plabuhan RT 06/ RW 02, Plabuhan Rejo- Lamongan";
        $role->phone = "08123123123";
        $role->birthdate = "1981-12-24";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3326160801880001";
        $role->name = "Muhamat Gunawan";
        $role->nickname = "AWAN";
        $role->address = "Dk. Gendogo Bondansari RT 06/ RW 03, Bondansari";
        $role->phone = "08123123123";
        $role->birthdate = "1988-01-08";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();
        $role = new Customer();
        $role->nik = "3515131811850007";
        $role->name = "Muhammad Misdu";
        $role->nickname = "AZIZ TAHU";
        $role->address = "Taman Utara RT 07/ RW 02, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1985-11-18";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130203010007";
        $role->name = "Moh. Maufiqur Rohman";
        $role->nickname = "MOUFIQUR";
        $role->address = "Medaeng Kulon RT 19/ RW 07, Kedungturi- Taman";
        $role->phone = "08123123123";
        $role->birthdate = "2001-03-02";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515132203720009";
        $role->name = "Mohammad Mujib";
        $role->nickname = "MUJIB";
        $role->address = "Dsn. Sambisari RT 30/ RW 06, Sambibulu - Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1972-03-22";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3326171111780001";
        $role->name = "Mohammad Waziz";
        $role->nickname = "AZIZ TEMPE";
        $role->address = "Dk. Saren RT 02/ RW 08, Blimbing Wuluh - Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1978-11-11";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3326170410840001";
        $role->name = "Muslimin";
        $role->nickname = "MUSLIMIN";
        $role->address = "Dk. Blimbing Lor RT 02/ RW 02, Blimbing Wuluh - Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1984-10-04";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3523170906740005";
        $role->name = "Moh. Yusuf";
        $role->nickname = "YUSUF TENGGILIS";
        $role->address = "Dsn. Kesamben Barat RT 01/ RW 03, Plumpang";
        $role->phone = "08123123123";
        $role->birthdate = "1974-06-09";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515131506840013";
        $role->name = "Nanang Naiwatmoko";
        $role->nickname = "NANANG";
        $role->address = "Taman RT 17/ RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1984-06-15";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515135702680008";
        $role->name = "Nuryati Lutfiyah";
        $role->nickname = "NURYATI";
        $role->address = "Dsn. Kempreng RT25/ RW 04, Tanjungsari - Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1968-02-17";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130608690007";
        $role->name = "Nur Cahyo";
        $role->nickname = "NURCY";
        $role->address = "Medaeng Kulon RT 20/ RW 07, Kedungturi - Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1969-08-06";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3502151012620002";
        $role->name = "Paekun";
        $role->nickname = "YADI";
        $role->address = "Bandar RT 07/ RW 03, Sepanjang";
        $role->phone = "08123123123";
        $role->birthdate = "1962-12-10";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130101710034";
        $role->name = "Pudjut Sujarwanto";
        $role->nickname = "JARWANTO";
        $role->address = "Sambibulu RT 29/ RW 05, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1971-01-01";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3507041404730002";
        $role->name = "Panut";
        $role->nickname = "PANUT";
        $role->address = "Druju RT 05/ RW 01, Druju";
        $role->phone = "08123123123";
        $role->birthdate = "1973-04-14";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3517132904830003";
        $role->name = "Purwanto";
        $role->nickname = "PUR TAHU";
        $role->address = "Dsn. Melik RT 05/ RW 05, Bedah Lawak - Tembelang";
        $role->phone = "08123123123";
        $role->birthdate = "1983-04-29";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3326176312800002";
        $role->name = "Risda Mirwansyah";
        $role->nickname = "IWAN";
        $role->address = "Jl. Jeruk 1 No 28B, Geluran - Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1980-12-23";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515132702860001";
        $role->name = "Reno Rela Hendrawan";
        $role->nickname = "HENDRA";
        $role->address = "Dsn. Sambisari Kav. Selatan Blok D19 RT 37/ RW 07, Sambibulu";
        $role->phone = "08123123123";
        $role->birthdate = "1986-02-27";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515131908630011";
        $role->name = "Rochmad";
        $role->nickname = "ROHMAT";
        $role->address = "Jl. Nangka 1C RT 15/ RW 03, Geluran";
        $role->phone = "08123123123";
        $role->birthdate = "1963-08-19";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3517170405740002";
        $role->name = "Sadali";
        $role->nickname = "SADELI";
        $role->address = "Legok RT 18/ RW06, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1974-05-04";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3326172104820005";
        $role->name = "Saifudin";
        $role->nickname = "UDIN";
        $role->address = "Dsn. Pait RT 01/ RW 03, Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1982-04-21";
        $role->type = "Eceran";
        $role->tb = 1000;
        $role->tw = 1000;
        $role->thr = 2000;
        $role->save();

        $item = new Item();
        $item->code = 'H';
        $item->brand = 'HIU';
        $item->save();

        $item = new Item();
        $item->code = 'B';
        $item->brand = 'BOLA';
        $item->save();
        $item = new Item();
        $item->code = 'TSC';
        $item->brand = 'TSC';
        $item->save();

        $item = new Item();
        $item->code = 'MJB';
        $item->brand = 'HIJAU';
        $item->save();

        $item = new Item();
        $item->code = 'MJK';
        $item->brand = 'KUNING';
        $item->save();

        $item = new Item();
        $item->code = 'PNH';
        $item->brand = 'PANAH';
        $item->save();

        $item = new Item();
        $item->code = 'SGR';
        $item->brand = 'SGR';
        $item->save();

        $item = new Item();
        $item->code = 'PGD';
        $item->brand = 'PAGODA';
        $item->save();

        $role = new Vehicle();
        $role->name = 'Truk A';
        $role->type = "Truk";
        $role->save();

        $role = new Vehicle();
        $role->name = 'L-300 A';
        $role->type = "Pickup";
        $role->save();


    }
}
