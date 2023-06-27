<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Item;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cas_deposits')->insert([
            "koin" => 0,
            "seribu" => 0,
            "duaribu" => 0,
            "limaribu" => 0,
            "sepuluhribu" => 0,
            "duapuluhribu" => 0,
        ]);


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
        $user->password = Hash::make('meli13052004');
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
        $role->ongkir = 100000;
        $role->birthdate = "1972-08-16";
        $role->type = "Kiriman";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 2;
        $role->tonnage = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3578202660700002";
        $role->name = "Iskandar";
        $role->nickname = "ISKANDAR";
        $role->address = "Wiyung 4/100 RT 02/ RW 06";
        $role->phone = "08123123123";
        $role->birthdate = "1970-06-26";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 3450000;
        $role->cashback_days = 22;
        $role->tonnage = 325.5;
        $role->save();



        $role = new Customer();
        $role->nik = "3503051902860000";
        $role->name = "Achmad Tohari";
        $role->nickname = "AHMAD";
        $role->address = "Dsn. Krajan RT 12/ RW 03, Nglongsor - Tugu";
        $role->phone = "08123123123";
        $role->birthdate = "1986-02-19";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "3515140606610001";
        $role->name = "Achmad Misbachul Munir";
        $role->nickname = "MUNIR";
        $role->address = "Masangan Kulon RT 01 / RW 01, Sukodono";
        $role->phone = "08123123123";
        $role->birthdate = "1961-06-06";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 840000;
        $role->cashback_days = 21;
        $role->tonnage = 393.85;
        $role->save();


        $role = new Customer();
        $role->nik = "3515130607800007";
        $role->name = "Aeidul Kohar";
        $role->nickname = "KOHAR";
        $role->address = "Kedungboto RT 18 / RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1980-07-06";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "3578172702850002";
        $role->name = "Adi Purwanto";
        $role->nickname = "HALIM";
        $role->address = "Tanah Merah Indah Syur 6/7 RT 24/ RW 04, Tanah Kali Kedinding";
        $role->phone = "08123123123";
        $role->birthdate = "1985-02-27";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3526131808820005";
        $role->name = "Agus Priyanto";
        $role->nickname = "KIPLI TAHU";
        $role->address = "Kedungboto RT 17 / RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1982-08-18";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 311700;
        $role->cashback_days = 26;
        $role->tonnage = 985.5;
        $role->save();


        $role = new Customer();
        $role->nik = "3518041011860003";
        $role->name = "Agus Sutamaji";
        $role->nickname = "AJI YAYAK";
        $role->address = "Dsn. Krembangan RT 03 / RW 01, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1986-11-10";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 1200000;
        $role->cashback_days = 3;
        $role->tonnage = 4100;
        $role->save();


        $role = new Customer();
        $role->nik = "3515141309740001";
        $role->name = "Agustinus";
        $role->nickname = "AGUS JINGGO";
        $role->address = "Legok RT 16 / RW 06, Sukodono";
        $role->phone = "08123123123";
        $role->birthdate = "1974-09-13";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 2900000;
        $role->cashback_days = 26;
        $role->tonnage = 3791.5;
        $role->save();

        $role = new Customer();
        $role->nik = "3505211708750002";
        $role->name = "Agus Tono";
        $role->nickname = "AGUS VEGA";
        $role->address = "Dsn. Sadang RT 01/RW 01, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1975-08-17";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->cashback_days = 12;
        $role->tonnage = 425;

        $role->save();

        $role = new Customer();
        $role->nik = "3515131911780006";
        $role->name = "Aji Parminardi";
        $role->nickname = "DIDIK TAHU";
        $role->address = "Dsn. Sambisari RT 26/RW 05, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1978-11-19";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->cashback_days = 20;
        $role->tonnage = 578.5;
        $role->save();

        $role = new Customer();
        $role->nik = "3577031005790004";
        $role->name = "Alfin Ariyanto";
        $role->nickname = "ALPIN";
        $role->address = "Jelok RT 03/ RW 02, Kayen- Pacitan";
        $role->phone = "08123123123";
        $role->birthdate = "1979-05-10";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 500000;
        $role->cashback_days = 22;
        $role->tonnage = 663;
        $role->save();

        $role = new Customer();
        $role->nik = "3326192205940001";
        $role->name = "Amat Marulah";
        $role->nickname = "MARUL";
        $role->address = "Dk. Werdi Tengah RT 10/ RW 05, Wonokerto";
        $role->phone = "08123123123";
        $role->birthdate = "1994-05-22";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 1350000;
        $role->cashback_days = 26;
        $role->tonnage = 2147;
        $role->save();

        $role = new Customer();
        $role->nik = "0000000000000000";
        $role->name = "Martda Angelia Veronika";
        $role->nickname = "MARTDA";
        $role->address = "Perum, Taman Permata Indah E5";
        $role->phone = "085730034703";
        $role->birthdate = "2001-03-14";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 0;
        $role->tonnage = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "0000000000000000";
        $role->name = "Meilidya Purnamasari";
        $role->nickname = "MEILING";
        $role->address = "Perum, Taman Permata Indah E5";
        $role->phone = "085730034703";
        $role->birthdate = "2004-05-13";
        $role->type = "Eceran";
        $role->tb = 4500;
        $role->thr = 0;
        $role->cashback_days = 0;
        $role->tonnage = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "0000000000000000";
        $role->name = "Michael Angelo Marcellino";
        $role->nickname = "MICHAEL";
        $role->address = "Perum, Taman Permata Indah E5";
        $role->phone = "085730034703";
        $role->birthdate = "2010-10-09";
        $role->type = "Eceran";
        $role->tb = 1455000;
        $role->thr = 0;
        $role->cashback_days = 0;
        $role->tonnage = 0;
        $role->save();



        $role = new Customer();
        $role->nik = "3506032402750001";
        $role->name = "Andis Dwi Suranto";
        $role->nickname = "DWI";
        $role->address = "Dsn. Kevling Kalibader RT 21/ RW 03, Taman ";
        $role->phone = "08123123123";
        $role->birthdate = "1975-02-24";
        $role->type = "Eceran";
        $role->tb = 1040000;
        $role->thr = 510000;
        $role->cashback_days = 26;
        $role->tonnage = 442;
        $role->save();


        $role = new Customer();
        $role->nik = "3515132512870002";
        $role->name = "Andi Nasir";
        $role->nickname = "ANDI TAHU";
        $role->address = "Taman RT 17/RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1987-12-25";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 50000;
        $role->cashback_days = 1;
        $role->tonnage = 48;
        $role->save();

        $role = new Customer();
        $role->nik = "3578203010860001";
        $role->name = "Andi Yulefi";
        $role->nickname = "ANDI WIYUNG";
        $role->address = "Wiyung RT 02/ RW 06";
        $role->phone = "08123123123";
        $role->birthdate = "1986-10-30";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 1675000;
        $role->cashback_days = 25;
        $role->tonnage = 723;
        $role->save();

        $role = new Customer();
        $role->nik = "3525131406800001";
        $role->name = "Arik Masrufi";
        $role->nickname = "ARIK MENGANTI";
        $role->address = "Menganti RT 03/ RW 02 ";
        $role->phone = "08123123123";
        $role->ongkir = 135000;
        $role->birthdate = "1980-06-14";
        $role->type = "Kiriman";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 1;
        $role->tonnage = 1000;
        $role->save();

        $role = new Customer();
        $role->nik = "3525156012670001";
        $role->name = "Arnasih";
        $role->nickname = "ARNASIH";
        $role->address = "Dsn. Lopang RT 01/ RW 04, Driyorejo";
        $role->phone = "08123123123";
        $role->birthdate = "1967-12-06";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 3407800;
        $role->save();

        $role = new Customer();
        $role->nik = "0000000000000000";
        $role->name = "Abas";
        $role->nickname = "ABAS";
        $role->address = "xxxxxxxxxxxxxxxxxx";
        $role->phone = "0000000000000000";
        $role->birthdate = "1967-01-07";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr =0;
        $role->cashback_days = 8;
        $role->tonnage = 750;
        $role->save();

        $role->nik = "0000000000000000";
        $role->name = "Abah";
        $role->nickname = "ABAH";
        $role->address = "xxxxxxxxxxxxxxxxxx";
        $role->phone = "0000000000000000";
        $role->birthdate = "1967-01-09";
        $role->type = "Eceran";
        $role->tb = 500000;
        $role->thr =0;
        $role->save();

        $role = new Customer();
        $role->nik = "3525154104740003";
        $role->name = "Aseh";
        $role->nickname = "BU ASIH";
        $role->address = "Jl. Merapi RT 07/ RW 02, Bambe- Driyorejo";
        $role->phone = "08123123123";
        $role->birthdate = "1974-04-14";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 15000;
        $role->cashback_days = 24;
        $role->tonnage = 289.3;
        $role->save();


        $role = new Customer();
        $role->nik = "3515132411710005";
        $role->name = "Astoi";
        $role->nickname = "TOIN";
        $role->address = "Jl. Sawunggaling I RT 15/ RW 03, Jemundo - Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1971-11-24";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 900000;
        $role->cashback_days = 4;
        $role->tonnage = 400;
        $role->save();

        $role = new Customer();
        $role->name = "Amin";
        $role->nickname = "AMIN COMONG";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "000000000000";
        $role->birthdate = "1971-10-14";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 9;
        $role->tonnage = 400;
        $role->save();

        $role = new Customer();
        $role->name = "Benu";
        $role->nickname = "BENU 1212";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "000000000000";
        $role->birthdate = "1971-09-17";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 120000;
        $role->cashback_days = 11;
        $role->tonnage = 229.5;
        $role->save();


        $role = new Customer();
        $role->nik = "3328162881830021";
        $role->name = "BAKRI";
        $role->nickname = "BAKRI JUANDA";
        $role->address = "Bondansari RT 06/ RW 03, Wiradesa";
        $role->phone = "08123123123";
        $role->ongkir = 150000;
        $role->birthdate = "1971-11-24";
        $role->type = "Kiriman";
        $role->tb = 0;
        $role->thr = 2100000;
        $role->cashback_days = 3;
        $role->tonnage = 5000;
        $role->save();

        $role = new Customer();
        $role->nik = "3326161306750001";
        $role->name = "Bambang Junaedi";
        $role->nickname = "JUNED";
        $role->address = "Bondansari RT 06/ RW 03, Wiradesa";
        $role->phone = "08123123123";
        $role->birthdate = "1975-06-13";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 2800000;
        $role->cashback_days = 26;
        $role->tonnage = 3387;
        $role->save();

        $role = new Customer();
        $role->nik = "3515132303720009";
        $role->name = "Basuki";
        $role->nickname = "ABAS";
        $role->address = "Taman Barat RT 01/ RW 01, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1972-03-23";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "3515130210900005";
        $role->name = "Bayu Aditama";
        $role->nickname = "BAYU";
        $role->address = "Kedungboto RT 17/ RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1990-10-02";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 620000;
        $role->cashback_days = 5;
        $role->tonnage = 184;
        $role->save();

        $role = new Customer();
        $role->nik = "3506171508670006";
        $role->name = "Budiaji";
        $role->nickname = "PAK JI AFIF";
        $role->address = "Jl. Bintan 2 RT 01/ RW 10, Palem - Pare";
        $role->phone = "08123123123";
        $role->birthdate = "1967-08-15";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 6;
        $role->tonnage = 93;
        $role->save();

        $role = new Customer();
        $role->nik = "3326083006650006";
        $role->name = "Casirin";
        $role->nickname = "BIRIN";
        $role->address = "Jl. Ubi 1 RT 01/ RW 10, Wage -  Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1965-06-30";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130304680005";
        $role->name = "Dadan Suryanda";
        $role->nickname = "DADAN";
        $role->address = "Taman RT 17/ RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1968-04-03";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 181800;
        $role->cashback_days = 22;
        $role->tonnage = 517;
        $role->save();

        $role = new Customer();
        $role->nik = "3326171903780001";
        $role->name = "Dama";
        $role->nickname = "DAMAK";
        $role->address = "Jl. Bagus Santri RT 04/ RW 02, Bohar- Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1978-03-19";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 22500000;
        $role->cashback_days = 21;
        $role->tonnage = 2745;
        $role->save();

        $role = new Customer();
        $role->nik = "3515134102770001";
        $role->name = "Dewi Wahyuni";
        $role->nickname = "KHOLIS";
        $role->address = "Taman RT 17/ RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1977-02-14";
        $role->type = "Eceran";
        $role->tb = 40000;
        $role->thr = 2600000;
        $role->cashback_days = 24;
        $role->tonnage = 2265.5;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130607550001";
        $role->name = "Djunaidi";
        $role->nickname = "ZUNAIDI";
        $role->address = "Dsn. Sambisari RT 29/ RW 05, Sambibulu - Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1955-07-06";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3326172503920004";
        $role->name = "Doni Setiawan";
        $role->nickname = "DONI";
        $role->address = "Dsn. Boyoteluk 3 RT 02/ RW 06, Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1992-03-25";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "3578240712680003";
        $role->name = "Dowo Wibowo";
        $role->nickname = "WIBOWO";
        $role->address = "Tenggilis Lama 4-A/12 RT 07/ RW 04, Tenggilis Mejoyo";
        $role->phone = "08123123123";
        $role->birthdate = "1968-12-07";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "3326161507870043";
        $role->name = "Edi Pramono";
        $role->nickname = "PRAMONO";
        $role->address = "Pekuncen RT 03/ RW 07, Wiradesa";
        $role->phone = "08123123123";
        $role->birthdate = "1987-07-15";
        $role->type = "Eceran";
        $role->tb = 1260000;
        $role->thr = 840000;
        $role->cashback_days = 24;
        $role->tonnage = 1200;
        $role->save();


        $role = new Customer();
        $role->nik = "3326170906960001";
        $role->name = "Edi Purwanto";
        $role->nickname = "ANTOK";
        $role->address = "Dk. Cangkring Kulon RT 01/ RW 08, Tengengwetan - Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1996-06-09";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3326193001750006";
        $role->name = "Edi Waluyo";
        $role->nickname = "WALUYO BHR";
        $role->address = "Dk. Keludan RT 02/ RW 01, Werdi- Wonokerto";
        $role->phone = "08123123123";
        $role->birthdate = "1975-01-30";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 650000;
        $role->cashback_days = 18;
        $role->tonnage = 1030;
        $role->save();


        $role = new Customer();
        $role->nik = "3515131909820007";
        $role->name = "EKO ADI W";
        $role->nickname = "ADI ABI";
        $role->address = "Kedungboto RT 17/ RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1982-09-19";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 5500000;
        $role->cashback_days = 23;
        $role->tonnage = 1404;
        $role->save();


        $role = new Customer();
        $role->nik = "3515131010690016";
        $role->name = "Elijas Boediono";
        $role->nickname = "PAK YAS";
        $role->address = "Sambisari Perintis 4 RT 36/ RW 07, Taman";
        $role->phone = "08123123123";
        $role->ongkir = 75000;
        $role->birthdate = "1969-10-10";
        $role->type = "Kiriman";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 1;
        $role->tonnage = 2100;
        $role->save();

        $role = new Customer();
        $role->nik = "3518121111890002";
        $role->name = "Erma Purnama ";
        $role->nickname = "KLIWON";
        $role->address = "Kemlaten 8/24 RT 01/ RW 06, Kebraon - Karangpilang";
        $role->phone = "08123123123";
        $role->birthdate = "1989-11-11";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 600000;
        $role->cashback_days = 26;
        $role->tonnage = 1084;
        $role->save();


        $role = new Customer();
        $role->nik = "3211171202700009";
        $role->name = "Eman Sulaeman";
        $role->nickname = "EMAN";
        $role->address = "Dsn. Sukamulya RT 05/ RW 01, Gunungsari";
        $role->phone = "08123123123";
        $role->birthdate = "1970-02-12";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->cashback_days = 24;
        $role->tonnage = 1180;
        $role->save();


        $role = new Customer();
        $role->nik = "3515146811750001";
        $role->name = "Erniatin";
        $role->nickname = "MBAK TIN";
        $role->address = "Saimbang RT 13/ RW 04, Kebon Agung- Sukodono";
        $role->phone = "08123123123";
        $role->ongkir = 100000;
        $role->birthdate = "1975-11-28";
        $role->type = "Kiriman";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 1;
        $role->tonnage = 2000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515135906710001";
        $role->name = "Ernamawati, S.PD.";
        $role->nickname = "ERNA";
        $role->address = "Jl. Sawunggaling 1 RT 15/ RW 02, Jemundo -  Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1971-06-19";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 164200;
        $role->cashback_days = 24;
        $role->tonnage = 240;
        $role->save();


        $role = new Customer();
        $role->nik = "3515140601800001";
        $role->name = "Giyanto";
        $role->nickname = "GIANTO";
        $role->address = "Sukolegok RT 16 / RW 06, Sukodono";
        $role->phone = "08123123123";
        $role->birthdate = "1980-01-06";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 950000;
        $role->cashback_days = 19;
        $role->tonnage = 957;
        $role->save();
        $role = new Customer();
        $role->nik = "0000000000000000";
        $role->name = "Gatot";
        $role->nickname = "GATOT";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "08123123123";
        $role->birthdate = "1980-01-07";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 15;
        $role->tonnage = 691.5;
        $role->save();



        $role = new Customer();
        $role->nik = "3326171709950002";
        $role->name = "Gunawan";
        $role->nickname = "GUNAWAN TOMPEL";
        $role->address = "Dk. Blimbing Lor RT 02/ RW 02, Blimbing Wuluh - Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1995-09-17";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();



        $role = new Customer();
        $role->nik = "3515130711670001";
        $role->name = "H. Nur. Kholiq";
        $role->nickname = "H. KHOLIK";
        $role->address = "Geluran RT 11/ RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1967-11-07";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 1820000;
        $role->cashback_days = 26;
        $role->tonnage = 2975.5;
        $role->save();


        $role = new Customer();
        $role->nik = "3326171507900001";
        $role->name = "Hadi Kurniawan";
        $role->nickname = "ADI AJAY";
        $role->address = "Wonosari RT 02/ RW 04, Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1990-07-15";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "00000000000000000";
        $role->name = "Hadi";
        $role->nickname = "HADI KEPUTIH";
        $role->address = "XXXXXXXXXXXXXXXXXXXXXX";
        $role->phone = "0000000000000";
        $role->birthdate = "1990-07-05";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->cashback_days = 1;
        $role->tonnage = 500;
        $role->save();

        $role = new Customer();
        $role->nik = "3326101507860002";
        $role->name = "Haryanto";
        $role->nickname = "HARR";
        $role->address = "Dukuh Sawi RT 02/ RW 07, Klunjukan - Sragi";
        $role->phone = "08123123123";
        $role->birthdate = "1986-07-15";
        $role->type = "Eceran";
        $role->tb = 2650000;
        $role->thr = 2650000;
        $role->cashback_days = 25;
        $role->tonnage = 1290;
        $role->save();


        $role = new Customer();
        $role->nik = "3578241206900001";
        $role->name = "Heri Setiyono";
        $role->nickname = "HERI SERUNI";
        $role->address = "Dsn. Ngudi RT 02/ RW 04, Punggul - Gedangan";
        $role->phone = "08123123123";
        $role->ongkir = 135000;
        $role->birthdate = "1990-06-12";
        $role->type = "Kiriman";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 2;
        $role->tonnage = 1150;
        $role->save();

        $role = new Customer();
        $role->nik = "3515142012790001";
        $role->name = "Imam Afandi";
        $role->nickname = "IMAM";
        $role->address = "Sukodono RT 05/ RW 01";
        $role->phone = "08123123123";
        $role->birthdate = "1979-12-20";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 1;
        $role->tonnage = 50;
        $role->save();


        $role = new Customer();
        $role->nik = "3515144710740002";
        $role->name = "Iin Sugiarini";
        $role->nickname = "IIN SAIMBANG";
        $role->address = "Saimbang RT 14/ RW 04, Kebon Agung - Sukodono";
        $role->phone = "08123123123";
        $role->ongkir = 100000;
        $role->birthdate = "1974-10-07";
        $role->type = "Kiriman";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 6;
        $role->tonnage = 12000;
        $role->save();

        $role = new Customer();
        $role->nik = "XXXXXXXXXXXXXXXX";
        $role->name = "Ruhiyat";
        $role->nickname = "RUHIYAT SEMAMBUNG";
        $role->address = "Semambung";
        $role->phone = "08123123123";
        $role->ongkir = 125000;
        $role->birthdate = "2023-10-07";
        $role->type = "Kiriman";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 4;
        $role->tonnage = 4600;
        $role->save();


        $role = new Customer();
        $role->nik = "3515131004730001";
        $role->name = "Imam Rokhmad";
        $role->nickname = "TOTOK";
        $role->address = "Dsn. Sambibulu RT 04/ RW 01, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1973-04-10";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 10;
        $role->tonnage = 421;
        $role->save();

        $role = new Customer();
        $role->nik = "XXXXXXXXXXXXXXXX";
        $role->name = "Mahmudi";
        $role->nickname = "MAHMUDI";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "08123123123";
        $role->birthdate = "2023-04-10";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 8;
        $role->tonnage = 750;
        $role->save();


        $role = new Customer();
        $role->nik = "3505152404930001";
        $role->name = "Indra Kurniawan";
        $role->nickname = "INDRA PAIJO";
        $role->address = "Terik RT 13 / RW 06, Krian";
        $role->phone = "08123123123";
        $role->birthdate = "1993-04-24";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 2050000;
        $role->cashback_days = 24;
        $role->tonnage = 1081.5;
        $role->save();

        $role = new Customer();
        $role->nik = "0000000000000000";
        $role->name = "Akemat";
        $role->nickname = "AKEMAT";
        $role->address = "xxxxxxxxxxxxxxxxx";
        $role->phone = "0000000000000000";
        $role->birthdate = "1984-11-9";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 18;
        $role->tonnage = 335;
        $role->save();


        $role = new Customer();
        $role->nik = "3517081012840007";
        $role->name = "Irwan";
        $role->nickname = "WAWAN A";
        $role->address = "Dsn. Watugaluh RT 01/ RW 02";
        $role->phone = "08123123123";
        $role->birthdate = "1984-12-10";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3515131507590002";
        $role->name = "Jemakir";
        $role->nickname = "BAKIR";
        $role->address = "Dsn. Sambisaei Kav. Selatan blok E-13, Sambibulu- Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1959-07-15";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 550000;
        $role->cashback_days = 19;
        $role->tonnage = 840;
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
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3578010605860002";
        $role->name = "Joko Vitono";
        $role->nickname = "JOKO TAHU";
        $role->address = "Kemlaten 10/2 RT 03/ RW 06, Kebraon – Karangpilang";
        $role->phone = "08123123123";
        $role->birthdate = "1986-05-06";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 1700000;
        $role->cashback_days = 25;
        $role->tonnage = 1214;
        $role->save();


        $role = new Customer();
        $role->nik = "3515130501790007";
        $role->name = "Joni Winarno Hadi W";
        $role->nickname = "JONI";
        $role->address = "Taman RT 18/ RW 03, Taman- Sidoarjo";
        $role->phone = "08123123123";
        $role->birthdate = "1979-01-05";
        $role->type = "Eceran";
        $role->tb = 10500000;
        $role->thr = 880000;
        $role->cashback_days = 24;
        $role->tonnage = 798;
        $role->save();


        $role = new Customer();
        $role->nik = "3515132101680004";
        $role->name = "Kusyono";
        $role->nickname = "AGUS K";
        $role->address = "Jl. Nanas RT 10/ RW 03, Geluran - Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1968-01-21";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->cashback_days = 13;
        $role->tonnage = 650;
        $role->save();

        $role = new Customer();
        $role->nik = "3327012105770005";
        $role->name = "Kasturi";
        $role->nickname = "KASTURI";
        $role->address = "Krajan 1 Wangkelang RT 02/ RW 01, Moga";
        $role->phone = "08123123123";
        $role->birthdate = "1977-05-21";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 812500;
        $role->cashback_days = 21;
        $role->tonnage = 10070;
        $role->save();

        $role = new Customer();
        $role->nik = "3515136409800002";
        $role->name = "Kartini";
        $role->nickname = "BU TINI";
        $role->address = "Jl. Ubi 2 Margomulyo RT 04/ RW 10, Wage - Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1980-09-24";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 7400000;
        $role->cashback_days = 4;
        $role->tonnage = 200;
        $role->save();

        $role = new Customer();
        $role->nik = "3326162909850001";
        $role->name = "Kisbandi";
        $role->nickname = "KISBANDI";
        $role->address = "Werdi RT 17/ RW 08, Wonokerto";
        $role->phone = "08123123123";
        $role->birthdate = "1985-09-29";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 1100000;
        $role->cashback_days = 26;
        $role->tonnage = 1545;
        $role->save();


        $role = new Customer();
        $role->nik = "3326190407920003";
        $role->name = "Kinto Surono";
        $role->nickname = "KINTO";
        $role->address = "Dsn. Dukuh RT 08/ RW 03, Bangsri – Sukodono ";
        $role->phone = "08123123123";
        $role->ongkir = 100000;
        $role->birthdate = "1992-07-04";
        $role->type = "Kiriman";
        $role->tb = 0;
        $role->thr = 4000000;
        $role->cashback_days = 2;
        $role->tonnage = 4400;
        $role->save();

        $role = new Customer();
        $role->nik = "3505101210820004";
        $role->name = "Kodofir";
        $role->nickname = "DOFIR";
        $role->address = "Dsn. Munggalan RT 08/ RW 05, Karangsono- Kanigaro";
        $role->phone = "08123123123";
        $role->birthdate = "1982-10-12";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
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
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3515135305840002";
        $role->name = "Lia Fanani";
        $role->nickname = "RIDHO";
        $role->address = "Sambisari RT 31/ RW 06";
        $role->phone = "08123123123";
        $role->birthdate = "1984-05-13";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 26;
        $role->tonnage = 832;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130105830008";
        $role->name = "M. Yusuf";
        $role->nickname = "YUSUF ANDIK";
        $role->address = "Banjarsari RT 08 /RW 03, Pertapaan – Maduretno Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1983-05-01";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "3308162811840001";
        $role->name = "Mahmudi ";
        $role->nickname = "MAHMUDI";
        $role->address = "Dsn. Mulung RT 07/ RW 04, Driyorejo";
        $role->phone = "08123123123";
        $role->birthdate = "1984-11-28";
        $role->type = "Eceran";
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3515132205990004";
        $role->name = "Mas Afif";
        $role->nickname = "AFIF";
        $role->address = "Dsn. Tanjunganom RT 11/ RW 01, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1999-05-22";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3517110103660008";
        $role->name = "Minto";
        $role->nickname = "MINTO";
        $role->address = "Dsn. Buduran RT 03/ RW 02, Jogoloyo";
        $role->phone = "08123123123";
        $role->birthdate = "1966-03-01";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 3200000;
        $role->cashback_days = 14;
        $role->tonnage = 686;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130206630006";
        $role->name = "Moch. Jimba Sunoto";
        $role->nickname = "JIMBA";
        $role->address = "Taman RT 15/ RW 03";
        $role->phone = "08123123123";
        $role->birthdate = "1963-06-02";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3515110610900003";
        $role->name = "Much. Fadelul";
        $role->nickname = "FADELI";
        $role->address = "Jenek Wetan RT 14/ RW 03, Krembangan- Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1990-10-06";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 2000000;
        $role->cashback_days = 26;
        $role->tonnage = 9150;
        $role->save();

        $role = new Customer();
        $role->nik = "0000000000000000";
        $role->name = "Tifany M";
        $role->nickname = "FANI";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "0859171683244";
        $role->birthdate = "1991-05-23";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 300000;
        $role->cashback_days = 0;
        $role->tonnage = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "0000000000000000";
        $role->name = "Firman";
        $role->nickname = "FIRMAN";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "000000000000";
        $role->birthdate = "1991-04-20";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 5;
        $role->tonnage = 8560;
        $role->save();

        $role = new Customer();
        $role->nik = "3515132207600002";
        $role->name = "Mugiono";
        $role->nickname = "GOCO";
        $role->address = "Taman RT 17/ RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1960-07-22";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "0000000000000000";
        $role->name = "Gondrong";
        $role->nickname = "Gondrong";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "0000000000000000";
        $role->birthdate = "1991-05-27";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 2;
        $role->tonnage = 200;
        $role->save();


        $role = new Customer();
        $role->nik = "3525151604700002";
        $role->name = "Moh. Irfan Shodiq";
        $role->nickname = "IRFAN TENARU";
        $role->address = "Tenaru RT 03/ RW 01, Driyorejo";
        $role->phone = "08123123123";
        $role->ongkir = 100000;
        $role->birthdate = "1970-04-16";
        $role->type = "Kiriman";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 1;
        $role->tonnage = 1000;
        $role->save();

        $role = new Customer();
        $role->nik = "3518122904930002";
        $role->name = "Muh. Kamat Yajib";
        $role->nickname = "YAJIB";
        $role->address = "Dsn. Cangak RT 01/ RW 05, Krandang";
        $role->phone = "08123123123";
        $role->birthdate = "1993-04-29";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 3000000;
        $role->cashback_days = 22;
        $role->tonnage = 1040;
        $role->save();


        $role = new Customer();
        $role->nik = "3326171506900002";
        $role->name = "Muhammad Roni";
        $role->nickname = "RONI";
        $role->address = "Dk. Saren RT 02/ RW 06, Blimbing Wuluh- Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1990-06-15";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 980000;
        $role->cashback_days = 26;
        $role->tonnage = 1104;
        $role->save();

        $role = new Customer();
        $role->nik = "XXXXXXXXXXXXXXXX";
        $role->name = "SUPRI TEMPE";
        $role->nickname = "SUPRI TEMPE";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "08123123123";
        $role->birthdate = "2023-06-15";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 8;
        $role->tonnage = 400;
        $role->save();


        $role = new Customer();
        $role->nik = "3326172610910002";
        $role->name = "Muhammad Wahyu";
        $role->nickname = "WAHYU TEMPE";
        $role->address = "Dk. Gemusuh RT 02/ RW 05, Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1991-10-26";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 2700000;
        $role->cashback_days = 20;
        $role->tonnage = 665;
        $role->save();

        $role = new Customer();
        $role->nik = "3525157006650110";
        $role->name = "Murtini";
        $role->nickname = "KARSAN";
        $role->address = "Dsn. Lopang RT 01/ RW 04, Driyorejo";
        $role->phone = "08123123123";
        $role->ongkir = 100000;
        $role->birthdate = "1965-06-30";
        $role->type = "Kiriman";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 1;
        $role->tonnage = 508;
        $role->save();

        $role = new Customer();
        $role->nik = "3515131110670004";
        $role->name = "Muslikin";
        $role->nickname = "LIKIN";
        $role->address = "Sambisari RT 34/ RW 07, Sambibulu -  Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1990-10-06";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 1240000;
        $role->cashback_days = 26;
        $role->tonnage = 1547.5;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130512720018";
        $role->name = "Moh. Juwari";
        $role->nickname = "JUHARI";
        $role->address = "Sadang Taman RT 02/ RW 01";
        $role->phone = "08123123123";
        $role->birthdate = "1972-12-05";
        $role->type = "Eceran";
        $role->tb = 1620000;
        $role->thr = 1620000;
        $role->cashback_days = 25;
        $role->tonnage = 875;
        $role->save();

        $role = new Customer();
        $role->nik = "3506202707730004";
        $role->name = "Moh. Mustakim";
        $role->nickname = "TAKIM";
        $role->address = "Dsn. Krembangan RT 02/ RW 01, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1973-07-27";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3515071107870009";
        $role->name = "Moh. Nurwahyudi";
        $role->nickname = "MASYUDI";
        $role->address = "Sepande RT 07/ RW 02, Candi - Sidoarjo";
        $role->phone = "08123123123";
        $role->birthdate = "1987-07-11";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 1500000;
        $role->cashback_days = 26;
        $role->tonnage = 666;
        $role->save();


        $role = new Customer();
        $role->nik = "3524162412810001";
        $role->name = "Muhajirin";
        $role->nickname = "MUHAJIRIN";
        $role->address = "Plabuhan RT 06/ RW 02, Plabuhan Rejo- Lamongan";
        $role->phone = "08123123123";
        $role->birthdate = "1981-12-24";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 20;
        $role->tonnage = 1411.5;
        $role->save();

        $role = new Customer();
        $role->nik = "XXXXXXXXXXXXXXXX";
        $role->name = "Mimi";
        $role->nickname = "MIMI";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "08123123123";
        $role->birthdate = "2023-12-24";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 4;
        $role->tonnage = 250;
        $role->save();


        $role = new Customer();
        $role->nik = "3326160801880001";
        $role->name = "Muhamat Gunawan";
        $role->nickname = "AWAN";
        $role->address = "Dk. Gendogo Bondansari RT 06/ RW 03, Bondansari";
        $role->phone = "08123123123";
        $role->birthdate = "1988-01-08";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 7200000;
        $role->cashback_days = 26;
        $role->tonnage = 2730;
        $role->save();



        $role = new Customer();
        $role->nik = "3515131811850007";
        $role->name = "Muhammad Misdu";
        $role->nickname = "AZIZ TAHU";
        $role->address = "Taman Utara RT 07/ RW 02, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1985-11-18";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 1080000;
        $role->cashback_days = 24;
        $role->tonnage = 814;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130203010007";
        $role->name = "Moh. Maufiqur Rohman";
        $role->nickname = "MOUFIQUR";
        $role->address = "Medaeng Kulon RT 19/ RW 07, Kedungturi- Taman";
        $role->phone = "08123123123";
        $role->birthdate = "2001-03-02";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 800000;
        $role->cashback_days = 5;
        $role->tonnage = 250;
        $role->save();

        $role = new Customer();
        $role->nik = "3515132203720009";
        $role->name = "Mohammad Mujib";
        $role->nickname = "MUJIB";
        $role->address = "Dsn. Sambisari RT 30/ RW 06, Sambibulu - Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1972-03-22";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "XXXXXXXXXXXXXXXX";
        $role->name = "Nur Sait";
        $role->nickname = "NUR SAIT";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "08123123123";
        $role->birthdate = "2023-03-22";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 12;
        $role->tonnage = 580;
        $role->save();


        $role = new Customer();
        $role->nik = "3326171111780001";
        $role->name = "Mohammad Waziz";
        $role->nickname = "AZIZ TEMPE";
        $role->address = "Dk. Saren RT 02/ RW 08, Blimbing Wuluh - Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1978-11-11";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3326170410840001";
        $role->name = "Muslimin";
        $role->nickname = "MUSLIMIN";
        $role->address = "Dk. Blimbing Lor RT 02/ RW 02, Blimbing Wuluh - Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1984-10-04";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3523170906740005";
        $role->name = "Moh. Yusuf";
        $role->nickname = "YUSUF TENGGILIS";
        $role->address = "Dsn. Kesamben Barat RT 01/ RW 03, Plumpang";
        $role->phone = "08123123123";
        $role->birthdate = "1974-06-09";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3515131506840013";
        $role->name = "Nanang Naiwatmoko";
        $role->nickname = "NANANG";
        $role->address = "Taman RT 17/ RW 03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1984-06-15";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3515135702680008";
        $role->name = "Nuryati Lutfiyah";
        $role->nickname = "NURYATI";
        $role->address = "Dsn. Kempreng RT25/ RW 04, Tanjungsari - Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1968-02-17";
        $role->type = "Eceran";
        $role->tb = 150000;
        $role->thr = 200000;
        $role->cashback_days = 3;
        $role->tonnage = 150;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130608690007";
        $role->name = "Nur Cahyo";
        $role->nickname = "NURCY";
        $role->address = "Medaeng Kulon RT 20/ RW 07, Kedungturi - Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1969-08-06";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->cashback_days = 18;
        $role->tonnage = 442;
        $role->save();

        $role = new Customer();
        $role->nik = "3502151012620002";
        $role->name = "Paekun";
        $role->nickname = "YADI";
        $role->address = "Bandar RT 07/ RW 03, Sepanjang";
        $role->phone = "08123123123";
        $role->birthdate = "1962-12-10";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->cashback_days = 4;
        $role->tonnage = 160;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130101710034";
        $role->name = "Pudjut Sujarwanto";
        $role->nickname = "JARWANTO";
        $role->address = "Sambibulu RT 29/ RW 05, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1971-01-01";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 7600000;
        $role->cashback_days = 24;
        $role->tonnage = 1200;
        $role->save();

        $role = new Customer();
        $role->nik = "3507041404730002";
        $role->name = "Panut";
        $role->nickname = "PANUT";
        $role->address = "Druju RT 05/ RW 01, Druju";
        $role->phone = "08123123123";
        $role->birthdate = "1973-04-14";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 19;
        $role->tonnage = 743;
        $role->save();

        $role = new Customer();
        $role->nik = "3517132904830003";
        $role->name = "Purwanto";
        $role->nickname = "PUR TAHU";
        $role->address = "Dsn. Melik RT 05/ RW 05, Bedah Lawak - Tembelang";
        $role->phone = "08123123123";
        $role->birthdate = "1983-04-29";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 8950000;
        $role->cashback_days = 18;
        $role->tonnage = 1056;
        $role->save();

        $role = new Customer();
        $role->nik = "0000000000000000";
        $role->name = "Ribut Lipurwanto";
        $role->nickname = "PUR GUDANG";
        $role->address = " xxxxxxxxxxxxxxxxxxxx";
        $role->phone = "000000000000";
        $role->birthdate = "1983-04-13";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 190000;
        $role->cashback_days = 0;
        $role->tonnage = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "3326176312800002";
        $role->name = "Risda Mirwansyah";
        $role->nickname = "IWAN";
        $role->address = "Jl. Jeruk 1 No 28B, Geluran - Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1980-12-23";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3515132702860001";
        $role->name = "Reno Rela Hendrawan";
        $role->nickname = "HENDRA";
        $role->address = "Dsn. Sambisari Kav. Selatan Blok D19 RT 37/ RW 07, Sambibulu";
        $role->phone = "08123123123";
        $role->birthdate = "1986-02-27";
        $role->type = "Eceran";
        $role->tb = 2750000;
        $role->thr = 2750000;
        $role->cashback_days = 24;
        $role->tonnage = 770;
        $role->save();

        $role = new Customer();
        $role->nik = "3515131908630011";
        $role->name = "Rochmad";
        $role->nickname = "ROHMAT";
        $role->address = "Jl. Nangka 1C RT 15/ RW 03, Geluran";
        $role->phone = "08123123123";
        $role->birthdate = "1963-08-19";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3517170405740002";
        $role->name = "Sadali";
        $role->nickname = "SADELI";
        $role->address = "Legok RT 18/ RW06, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1974-05-04";
        $role->type = "Eceran";
        $role->tb = 970000;
        $role->thr = 3570000;
        $role->cashback_days = 24;
        $role->tonnage = 3630;
        $role->save();

        $role = new Customer();
        $role->nik = "3326172104820005";
        $role->name = "Saifudin";
        $role->nickname = "UDIN";
        $role->address = "Dsn. Pait RT 01/ RW 03, Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1982-04-21";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->cashback_days = 4;
        $role->tonnage = 240;
        $role->save();



        $role = new Customer();
        $role->nik = "3276021701840016";
        $role->name = "Samuri B Kamari";
        $role->nickname = "SAMURI";
        $role->address = "PEDURENAN DEPOK RT.01/RW.01 CISALAK PASAR, CIMANGGIS";
        $role->phone = "08123123123";
        $role->birthdate = "1984-01-17";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 1265000;
        $role->cashback_days = 17;
        $role->tonnage = 1055;
        $role->save();


        $role = new Customer();
        $role->nik = "3326161501940001";
        $role->name = "Sanaji";
        $role->nickname = "SANAJI";
        $role->address = "Jl. Pagesangan Gg. Tambangan No.36 RT.01/RW.02, Jambangan";
        $role->phone = "08123123123";
        $role->birthdate = "1994-01-15";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 2850000;
        $role->cashback_days = 25;
        $role->tonnage = 2912;
        $role->save();


        $role = new Customer();
        $role->nik = "3315100206780001";
        $role->name = "Senen";
        $role->nickname = "SENEN";
        $role->address = "Sobo Widoro RT.01/RW.07 Trosobo, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1978-06-02";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 500000;
        $role->cashback_days = 13;
        $role->tonnage = 780;
        $role->save();


        $role = new Customer();
        $role->nik = "3578162510750010";
        $role->name = "Seger Purnomo";
        $role->nickname = "MINO";
        $role->address = "Simo Gunung Baru Jaya Blok E/02 RT.003/RW.15, Putat Jaya, Sawahan";
        $role->phone = "08123123123";
        $role->birthdate = "1975-10-25";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "3578244712880001";
        $role->name = "Seroja Dewi Saputri";
        $role->nickname = "PUTRI";
        $role->address = "Jl. Sambisari No.84 RT.31/RW.06 Sambibulu, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1988-12-07";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();




        $role = new Customer();
        $role->nik = "3578231610740001";
        $role->name = "Siaman";
        $role->nickname = "SIAMAN";
        $role->address = "Pagesangan III-A/26-A RT.04/RW.03. Jambangan";
        $role->phone = "08123123123";
        $role->birthdate = "1974-10-16";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 39250000;
        $role->cashback_days = 26;
        $role->tonnage = 7225.9;
        $role->save();


        $role = new Customer();
        $role->nik = "3515136508750007";
        $role->name = "Siti Fatimah";
        $role->nickname = "BU SALI";
        $role->address = "Kalijaten RT.23/RW.03, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1975-08-25";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 4000000;
        $role->cashback_days = 23;
        $role->tonnage = 1487.5;
        $role->save();


        $role = new Customer();
        $role->nik = "3525086001760002";
        $role->name = "Siti Jumayah";
        $role->nickname = "SOLIKIN SELEMPIT";
        $role->address = "Ds. Slempit RT.05/RW.01, Kedamean";
        $role->phone = "08123123123";
        $role->ongkir = 155000;
        $role->birthdate = "1976-01-20";
        $role->type = "Kiriman";
        $role->tb = 0;
        $role->thr = 1850000;
        $role->cashback_days = 0;
        $role->tonnage = 0;
        $role->save();




        $role = new Customer();
        $role->nik = "3326171610780001";
        $role->name = "Slamet Darmo";
        $role->nickname = "DARMO";
        $role->address = "Dk. Gumelem RT.10/RW.03 Gumawang, Pecalungan";
        $role->phone = "08123123123";
        $role->birthdate = "1978-10-16";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "351513107920005";
        $role->name = "Singgih Prasetiyo";
        $role->nickname = "SINGGIH";
        $role->address = "Taman RT.15/RW.03";
        $role->phone = "08123123123";
        $role->birthdate = "1992-07-16";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 330000;
        $role->cashback_days = 19;
        $role->tonnage = 341;
        $role->save();


        $role = new Customer();
        $role->nik = "3326174909840005";
        $role->name = "Siti Khotijah";
        $role->nickname = "RESTU";
        $role->address = "Dsn. Keben, RT.05/RW.01, Cangkringsari";
        $role->phone = "08123123123";
        $role->birthdate = "1984-09-09";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();




        $role = new Customer();
        $role->nik = "3515130609840005";
        $role->name = "Slamet Hariadi";
        $role->nickname = "HARI S";
        $role->address = "Bebekan Timur RT.09/RW.03 Taman-Sidoarjo";
        $role->phone = "08123123123";
        $role->birthdate = "1984-09-06";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 2100000;
        $role->cashback_days = 22;
        $role->tonnage = 579;
        $role->save();


        $role = new Customer();
        $role->nik = "3326170303810001";
        $role->name = "Slamet Raharjo";
        $role->nickname = "Slamet Tempe";
        $role->address = "Dk. Cangkring Kulon RT.001/RW.008 Tengenwetan,Siwalan";
        $role->phone = "08123123123";
        $role->birthdate = "1981-03-03";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "3326191702830006";
        $role->name = "Slamet Waluyo";
        $role->nickname = "WALUYO";
        $role->address = "Semut RT.03/RW.01, Wonokerto";
        $role->phone = "08123123123";
        $role->birthdate = "1983-02-17";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 1320000;
        $role->cashback_days = 15;
        $role->tonnage = 585;
        $role->save();


        $role = new Customer();
        $role->nik = " 3515181703790006";
        $role->name = "Soari";
        $role->nickname = "SOARI";
        $role->address = "Jl. Achmad II RT.01/RW.01 Pepelegi, Waru";
        $role->phone = "08123123123";
        $role->birthdate = "1979-03-17";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "3515131507600005";
        $role->name = "Sodiq Arianto";
        $role->nickname = "SODIK";
        $role->address = "Sambisari RT.032/RW.006, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1960-07-15";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 400000;
        $role->cashback_days = 10;
        $role->tonnage = 324;
        $role->save();


        $role = new Customer();
        $role->nik = "3515130811690004";
        $role->name = "Sri Wahono";
        $role->nickname = "WAHONO";
        $role->address = "Kedungturi RT.47/RW.13, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1969-11-08";
        $role->type = "Eceran";
        $role->tb = 510000;
        $role->thr = 550000;
        $role->cashback_days = 11;
        $role->tonnage = 615;
        $role->save();


        $role = new Customer();
        $role->nik = "3523050305770001";
        $role->name = "Subur Fauzi";
        $role->nickname = "Fauzi";
        $role->address = "Dsn. Tulung RT.05/RW.04 Rayung, Senori";
        $role->phone = "08123123123";
        $role->birthdate = "1977-05-03";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "3515130705890006";
        $role->name = "Sugeng Hariyadi";
        $role->nickname = "HARI EDY";
        $role->address = "Ketegan Barat Gg.03 RT05/RW.01, Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1989-05-07";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 640000;
        $role->cashback_days = 26;
        $role->tonnage = 444;
        $role->save();


        $role = new Customer();
        $role->nik = "3515133011740009";
        $role->name = "Suherman Mahmudi";
        $role->nickname = "Mahmudi";
        $role->address = "Dsn. Kletek RT.10/RW.05 Taman";
        $role->phone = "08123123123";
        $role->birthdate = "1974-11-30";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();








        $role = new Customer();
        $role->nik = "3524191906810002";
        $role->name = "SUKIRNO";
        $role->nickname = "SUKIR";
        $role->address = "TAMAN RT.08/RW.02";
        $role->phone = "08123123123";
        $role->birthdate = "1981-06-19";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "3525046101850002";
        $role->name = "SULAMI";
        $role->nickname = "SULAMI";
        $role->address = "DSN.KEBIN DALEM , RT.10/RW.03 DOMAS MENGANTI";
        $role->phone = "08123123123";
        $role->birthdate = "1985-01-21";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "3515131206660007";
        $role->name = "SUMADI";
        $role->nickname = "SUMADI";
        $role->address = "SAMBISARI KAV.UTARA, RT.35/RW.06 SAMBIBULU, TAMAN";
        $role->phone = "08123123123";
        $role->birthdate = "1966-06-12";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();




        $role = new Customer();
        $role->nik = "3326170108760002";
        $role->name = "SUMADI";
        $role->nickname = "SUMADI TEMPE";
        $role->address = "WONOTUNGGAL";
        $role->phone = "08123123123";
        $role->birthdate = "1976-08-01";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 3920000;
        $role->cashback_days = 23;
        $role->tonnage = 2300;
        $role->save();


        $role = new Customer();
        $role->nik = "3515130101580087";
        $role->name = "SUMADJI";
        $role->nickname = "PAK JI JEMUNDO ";
        $role->address = "JL.SAWUNGGALING I RT.15/RW.03 JEMUNDO, TAMAN ";
        $role->phone = "08123123123";
        $role->ongkir = 100000;
        $role->birthdate = "1958-01-01";
        $role->type = "Kiriman";
        $role->tb = 19500000;
        $role->thr = 0;
        $role->cashback_days = 2;
        $role->tonnage = 1348;
        $role->save();


        $role = new Customer();
        $role->nik = "1214163101540000";
        $role->name = "SUMANTO";
        $role->nickname = "MANTO";
        $role->address = "KEDUNGBOTO, RT.15/RW.03, TAMAN";
        $role->phone = "08123123123";
        $role->birthdate = "1954-01-31";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();



        $role = new Customer();
        $role->nik = "3515132508930005";
        $role->name = "SUNARDI";
        $role->nickname = "SUNARDI";
        $role->address = "JL.SAWUNGGALING III RT.20/RW.04 JEMUNDO - TAMAN";
        $role->phone = "08123123123";
        $role->birthdate = "1993-08-25";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "3515132702760005";
        $role->name = "SUNARDI";
        $role->nickname = "NARDI";
        $role->address = "BEBEKAN SELATAN, RT.24/RW.07, TAMAN";
        $role->phone = "08123123123";
        $role->ongkir = 100000;
        $role->birthdate = Carbon::now();
        $role->type = "Kiriman";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 3;
        $role->tonnage = 6000;
        $role->save();


        $role = new Customer();
        $role->nik = "9104016612690001";
        $role->name = "SUNARSIH";
        $role->nickname = "UNTUNG";
        $role->address = "JL.DR.SOETOMO , RT.05 NABARLIA NABIRE";
        $role->phone = "08123123123";
        $role->birthdate = "1969-12-26";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();



        $role = new Customer();
        $role->nik = "3578230102670001";
        $role->name = "SUNARTO";
        $role->nickname = "NARTO";
        $role->address = "JL.PAGESANGAN RAYA NO.99 RT.04/RW.02, JAMBANGAN";
        $role->phone = "08123123123";
        $role->birthdate = "1967-02-01";
        $role->type = "Eceran";
        $role->tb = 270000;
        $role->thr = 30000;
        $role->cashback_days = 26;
        $role->tonnage = 1221;
        $role->save();

        $role = new Customer();
        $role->nik = "XXXXXXXXXXXXXXXX";
        $role->name = "Putri";
        $role->nickname = "PUTRI";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "08123123123";
        $role->birthdate = "2023-02-01";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 7;
        $role->tonnage = 145;
        $role->save();



        $role = new Customer();
        $role->nik = "3525151008750003";
        $role->name = "SUPRIADI";
        $role->nickname = "SUPRI TEMPE";
        $role->address = "CANGKIR, RT.03/RW.01, DRIYOREJO";
        $role->phone = "08123123123";
        $role->birthdate = "1975-08-10";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "3515135102730002";
        $role->name = "SUPRIANIK";
        $role->nickname = "ANIK";
        $role->address = "BOHAR TIMUR RT.12/RW.07";
        $role->phone = "08123123123";
        $role->birthdate = "1973-02-11";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 1099800;
        $role->cashback_days = 25;
        $role->tonnage = 1298;
        $role->save();




        $role = new Customer();
        $role->nik = "3515130502820004";
        $role->name = "SUROSO";
        $role->nickname = "SUROSO";
        $role->address = "TANJUNGSARI RT.16/RW.02, TAMAN ";
        $role->phone = "08123123123";
        $role->birthdate = "1982-02-05";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "3516172305730001";
        $role->name = "TIKNO";
        $role->nickname = "TIKNO";
        $role->address = "KALIJATEN RT.17/RW.03, TAMAN";
        $role->phone = "08123123123";
        $role->birthdate = "1973-05-23";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 3850000;
        $role->cashback_days = 25;
        $role->tonnage = 672;
        $role->save();

        $role = new Customer();
        $role->nik = "0000000000000000";
        $role->name = "TORO";
        $role->nickname = "TORO KEDURUS";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx ";
        $role->phone = "000000000000";
        $role->birthdate = "1973-06-11";
        $role->type = "Kiriman";
        $role->tb = 60000;
        $role->thr = 50000;
        $role->cashback_days = 1;
        $role->tonnage = 1000;
        $role->save();


        $role = new Customer();
        $role->nik = "XXXXXXXXXXXXXXXX";
        $role->name = "PAK DAR";
        $role->nickname = "PAK DAR";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "08123123123";
        $role->birthdate = "2023-05-23";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 3600000;
        $role->cashback_days = 0;
        $role->tonnage = 0;
        $role->save();



        $role = new Customer();
        $role->nik = "3518120108870001";
        $role->name = "SUWARDI";
        $role->nickname = "SUWARDI";
        $role->address = "DSN.KALIJINAK RT.01/RW.01, SUMBERBENDO, PUCANGLABAN";
        $role->phone = "08123123123";
        $role->birthdate = "1987-08-01";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();




        $role = new Customer();
        $role->nik = "3326174101730002";
        $role->name = "SUWARNI";
        $role->nickname = "SUWARNI";
        $role->address = "DS.SUKO LEGOK IV RT.17/RW.06 SUKO, SUKODONO";
        $role->phone = "08123123123";
        $role->birthdate = "1973-01-01";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();


        $role = new Customer();
        $role->nik = "3515141009680007";
        $role->name = "SUWARNO";
        $role->nickname = "SUWARNO";
        $role->address = "BANGSRI RT.17/RW.02 SUKODONO";
        $role->phone = "08123123123";
        $role->birthdate = "1968-09-10";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 570000;
        $role->cashback_days = 26;
        $role->tonnage = 1140;
        $role->save();

        $role = new Customer();
        $role->nik = "XXXXXXXXXXXXXXXX";
        $role->name = "SAMSURI";
        $role->nickname = "SAMSURI";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "08123123123";
        $role->birthdate = "2023-09-10";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 6;
        $role->tonnage = 216;
        $role->save();


        $role = new Customer();
        $role->nik = "3506152510750002";
        $role->name = "SUWARSO";
        $role->nickname = "WARSO";
        $role->address = "SAWO II, RT.02/RW.03, KARANGJATI";
        $role->phone = "08123123123";
        $role->birthdate = "1975-10-25";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();




        $role = new Customer();
        $role->nik = "3515130105690008";
        $role->name = "SUWOTO";
        $role->nickname = "BROTO";
        $role->address = "TAMAN RT 17/ RW 03, TAMAN";
        $role->phone = "08123123123";
        $role->birthdate = "1969-05-01";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->cashback_days = 18;
        $role->tonnage = 312;
        $role->save();


        $role = new Customer();
        $role->nik = "3515141003840002";
        $role->name = "SYAIFUL ANAM";
        $role->nickname = "ANAM";
        $role->address = "DSN. CUMPLENG RT 14/ RW 05, BANGSRI - SUKODONO";
        $role->phone = "08123123123";
        $role->birthdate = "1984-03-10";
        $role->type = "Eceran";
        $role->tb = 1040000;
        $role->thr = 520000;
        $role->cashback_days = 21;
        $role->tonnage = 2138;
        $role->save();


        $role = new Customer();
        $role->nik = "3506202505750003";
        $role->name = "TAUFIK MASHUDI";
        $role->nickname = "HUDI";
        $role->address = "PAGESANGAN 2-A/10 RT 01/ RW 02 JAMBANGAN";
        $role->phone = "08123123123";
        $role->birthdate = "1975-05-25";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();




        $role = new Customer();
        $role->nik = "3326190809800004";
        $role->name = "TARYONO";
        $role->nickname = "YONO";
        $role->address = "DUKUH GEMURUH RT 02/ RW 05, SIWALAN ";
        $role->phone = "08123123123";
        $role->birthdate = "1980-09-08";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 2960000;
        $role->cashback_days = 23;
        $role->tonnage = 725;
        $role->save();


        $role = new Customer();
        $role->nik = "3515130701810005";
        $role->name = "TUNAS PRASETYO HADI";
        $role->nickname = "PRASS";
        $role->address = "DSN. SAMBIBULU RT 09/ RW 02, TAMAN";
        $role->phone = "08123123123";
        $role->birthdate = "1981-01-07";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 620000;
        $role->cashback_days = 17;
        $role->tonnage = 525;
        $role->save();


        $role = new Customer();
        $role->nik = "3519151805700001";
        $role->name = "UMAN ARIGONG";
        $role->nickname = "UMAN";
        $role->address = "WONOSARI RT 02/ RW 01";
        $role->phone = "08123123123";
        $role->birthdate = "1970-05-18";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 2450000;
        $role->cashback_days = 25;
        $role->tonnage = 1385.5;
        $role->save();




        $role = new Customer();
        $role->nik = "3515136604730003";
        $role->name = "UMRIYAH";
        $role->nickname = "UMRIYAH";
        $role->address = "WONOCOLO RT 04/ RW 02, TAMAN";
        $role->phone = "08123123123";
        $role->birthdate = "1973-04-26";
        $role->type = "Eceran";
        $role->tb = 2750000;
        $role->thr = 1050000;
        $role->cashback_days = 26;
        $role->tonnage = 1565;
        $role->save();


        $role = new Customer();
        $role->nik = "3515132304760008";
        $role->name = "WAHYU SETIAWAN";
        $role->nickname = "WA-ONE";
        $role->address = "WONOCOLO SELATAN RT 16/ RW 06, TAMAN";
        $role->phone = "08123123123";
        $role->birthdate = "1976-04-23";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 680000;
        $role->cashback_days = 17;
        $role->tonnage = 592;
        $role->save();





        $role = new Customer();
        $role->nik = "3326172404990002";
        $role->name = "WAKHIDI RIYONO";
        $role->nickname = "DIDIK TEMPE";
        $role->address = "DK. CANGKRING KULON RT 01/ RW 08, TENGENGWETAN - SIWALAN";
        $role->phone = "08123123123";
        $role->birthdate = "1999-04-24";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3515133012640006";
        $role->name = "WAKIDI";
        $role->nickname = "WAKIDI";
        $role->address = "MENYANGGONG RT 26/ RW 11, KLETEK";
        $role->phone = "08123123123";
        $role->birthdate = "1964-12-30";
        $role->type = "Eceran";
        $role->tb = 3550000;
        $role->thr = 3550000;
        $role->cashback_days = 8;
        $role->tonnage = 1561;
        $role->save();


        $role = new Customer();
        $role->nik = "3515130606700010";
        $role->name = "WALUYO SUKARSI";
        $role->nickname = "WALUYO BOHAR";
        $role->address = "BOHAR UTARA RT 03/ RW 02, TAMAN";
        $role->phone = "08123123123";
        $role->ongkir = 100000;
        $role->birthdate = "1970-06-30";
        $role->type = "Kiriman";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 1;
        $role->tonnage = 1000;
        $role->save();

        $role = new Customer();
        $role->nik = "3515131003710005";
        $role->name = "WARDOYO";
        $role->nickname = "WANDA";
        $role->address = "TAMAN RT 17/ RW 03, TAMAN";
        $role->phone = "08123123123";
        $role->birthdate = "1971-03-10";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();





        $role = new Customer();
        $role->nik = "3325070907810010";
        $role->name = "WASJURI";
        $role->nickname = "BAJURI";
        $role->address = "DUKUH BANTARAN RT 15/ RW 04, KETANGGAN";
        $role->phone = "08123123123";
        $role->birthdate = "1981-07-09";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 450000;
        $role->cashback_days = 22;
        $role->tonnage = 1175;
        $role->save();

        $role = new Customer();
        $role->nik = "0000000000000000";
        $role->name = "Barokah";
        $role->nickname = "BAROKAH";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "000000000000";
        $role->birthdate = "1981-06-08";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 8;
        $role->tonnage = 2871;
        $role->save();

        $role = new Customer();
        $role->nik = "0000000000000000";
        $role->name = "Bandi";
        $role->nickname = "BANDI";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "000000000000";
        $role->birthdate = "1981-06-08";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 1;
        $role->tonnage = 100;
        $role->save();



        $role = new Customer();
        $role->nik = "3515132506770010";
        $role->name = "WIYONO";
        $role->nickname = "WIYONO BOHAR";
        $role->address = "JL. BAGUS SANTRI RT 04/ RW 02, BOHAR-TAMAN";
        $role->phone = "08123123123";
        $role->ongkir = 100000;
        $role->birthdate = "1977-06-25";
        $role->type = "Kiriman";
        $role->tb = 0;
        $role->thr = 550000;
        $role->cashback_days = 1;
        $role->tonnage = 1000;
        $role->save();




        $role = new Customer();
        $role->nik = "3515130505640003";
        $role->name = "WONO SUTRIMO";
        $role->nickname = "TRIMO";
        $role->address = "DSN. SAMBISARI KAV. SELATAN BLOK B/20 RT 38/ RW 07, TAMAN";
        $role->phone = "08123123123";
        $role->birthdate = "1964-05-05";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 2400000;
        $role->cashback_days = 25;
        $role->tonnage = 1597;
        $role->save();

        $role = new Customer();
        $role->nik = "3515140207790003";
        $role->name = "YUDO ADI NUGROHO";
        $role->nickname = "YUDHO";
        $role->address = "DUSUN KRAJAN RT 01/ RW 01, TERBIS";
        $role->phone = "08123123123";
        $role->birthdate = "1979-07-02";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 130000;
        $role->cashback_days = 20;
        $role->tonnage = 595;
        $role->save();



        $role = new Customer();
        $role->nik = "3515162101910003";
        $role->name = "IMAM ARIFIN";
        $role->nickname = "IMAM ARIFIN";
        $role->address = "JL. TERATAI RT 01/ RW 01, KETAJEN - GEDANGAN ";
        $role->phone = "08123123123";
        $role->birthdate = "1991-01-21";
        $role->type = "Eceran";
        $role->tb = 280000;
        $role->thr = 0;
        $role->cashback_days = 7;
        $role->tonnage = 1229;
        $role->save();



        $role = new Customer();
        $role->nik = "3515131210750005";
        $role->name = "MOH. SAIKHU";
        $role->nickname = "SAIKU";
        $role->address = "JL. SAWUNGGALING 2 RT 01/ RW 01, JEMUNDO- TAMAN";
        $role->phone = "08123123123";
        $role->birthdate = "1975-10-12";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();



        $role = new Customer();
        $role->nik = "3515132201800010";
        $role->name = "AGUNG PRASETIYO";
        $role->nickname = "AGUNG ALOHA";
        $role->address = "KUTEI 2/ 23-A RT 09/ RW 06, DARMO";
        $role->phone = "08123123123";
        $role->birthdate = "1980-01-22";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 80000;
        $role->cashback_days = 23;
        $role->tonnage = 680;
        $role->save();

        $role = new Customer();
        $role->nik = "3578243004700001";
        $role->name = "ALI JAHRI";
        $role->nickname = "P. ALI TENGGILIS";
        $role->address = "TENGGILIS LAMA III/ 39, TENGGILIS MEJOYO, SURABAYA";
        $role->phone = "08123123123";
        $role->ongkir = 100000;
        $role->birthdate = "1970-04-30";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();

        $role = new Customer();
        $role->nik = "3515130901850006";
        $role->name = "IMAM HANAFI";
        $role->nickname = "HANAFI";
        $role->address = "TAMAN UTARA RT.007/RW.002, TAMAN";
        $role->phone = "08123123123";
        $role->birthdate = "1985-01-09";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 8;
        $role->tonnage = 404;
        $role->save();

        $role = new Customer();
        $role->nik = "3518081612690002";
        $role->name = "HUDIN";
        $role->nickname = "UDIN WAKIDI";
        $role->address = "DSN.SAMBIJAJAR RT.001/RW.022 DRENGES, KERTOSONO";
        $role->phone = "08123123123";
        $role->birthdate = "1969-12-16";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 2700000;
        $role->cashback_days = 6;
        $role->tonnage = 860;
        $role->save();

        $role = new Customer();
        $role->nik = "xxxxxxxxxxxxxxxx";
        $role->name = "HUDIN";
        $role->nickname = "HUDIN";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "08123123123";
        $role->birthdate = "2023-12-16";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 0;
        $role->cashback_days = 14;
        $role->tonnage = 240;
        $role->save();


        $role = new Customer();
        $role->nik = "3326172103010001";
        $role->name = "NUR SAIT";
        $role->nickname = "NUR SAIT";
        $role->address = "DK.LOROG RT.001/ RW.003 SIWALAN, PEKALONGAN";
        $role->phone = "08123123123";
        $role->birthdate = "2001-03-21";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();



        $role = new Customer();
        $role->nik = "3578220712860003";
        $role->name = "AKEMAT SUMANDI";
        $role->nickname = "AKEMAT SUMANDI";
        $role->address = "DUKUH MENANGGAL 6/61 RT.001 RW.002 GAYUNGAN";
        $role->phone = "08123123123";
        $role->birthdate = Carbon::now();
        $role->type = "Eceran";
        $role->tb = 0;
        $role->tw = 0;
        $role->thr = 0;
        $role->save();




        $role = new Customer();
        $role->nik = "3515091209680007";
        $role->name = "ABD AZIZ";
        $role->nickname = "AZIZ";
        $role->address = "DSN SUDIMORO UTARA RT.002/RW.001 TULANGAN";
        $role->phone = "08123123123";
        $role->birthdate = "1968-09-12";
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 350000;
        $role->cashback_days = 11;
        $role->tonnage = 566;
        $role->save();


        $role = new Customer();
        $role->nik = "xxxxxxxxxxxxxxxx";
        $role->name = "Desuki";
        $role->nickname = "DESUKI";
        $role->address = "xxxxxxxxxxxxxxxxx";
        $role->phone = "08123123123";
        $role->birthdate = Carbon::now();
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 4234400;
        $role->cashback_days = 26;
        $role->tonnage = 826;
        $role->save();

        $role = new Customer();
        $role->nik = "xxxxxxxxxxxxxxxx";
        $role->name = "Herman";
        $role->nickname = "HERMAN";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx ";
        $role->phone = "08123123123";
        $role->birthdate = Carbon::now();
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 660000;
        $role->cashback_days = 16;
        $role->tonnage = 800;
        $role->save();

        $role = new Customer();
        $role->nik = "xxxxxxxxxxxxxxxx";
        $role->name = "Imron";
        $role->nickname = "IMRON";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "08123123123";
        $role->birthdate = Carbon::now();
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 385000;
        $role->cashback_days = 3;
        $role->tonnage = 65;
        $role->save();

        $role = new Customer();
        $role->nik = "xxxxxxxxxxxxxxxx";
        $role->name = "ABD. Latif";
        $role->nickname = "ABD LATIF";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "08123123123";
        $role->birthdate = Carbon::now();
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 400000;
        $role->cashback_days = 3;
        $role->tonnage = 150;
        $role->save();

        $role = new Customer();
        $role->nik = "xxxxxxxxxxxxxxxx";
        $role->name = "Sodikan";
        $role->nickname = "SODIKAN";
        $role->address = "xxxxxxxxxxxxxxxxxxxxxxxx";
        $role->phone = "08123123123";
        $role->birthdate = Carbon::now();
        $role->type = "Eceran";
        $role->tb = 0;
        $role->thr = 120000;
        $role->cashback_days = 8;
        $role->tonnage = 236;
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



        $item = new Item();
        $item->code = 'SIP';
        $item->brand = 'SIPP';
        $item->save();


        $item = new Item();
        $item->code = 'RO';
        $item->brand = 'RAGI ONGGOK';
        $item->save();

        $item = new Item();
        $item->code = 'RLP';
        $item->brand = 'RAGI LIPPI PRIMA';
        $item->save();


        $item = new Item();
        $item->code = 'ROJ';
        $item->brand = 'RAGI ONGGOK JADI';
        $item->save();


        $item = new Item();
        $item->code = 'K.ONYOR';
        $item->brand = 'KRESEK ONYOR';
        $item->save();


        $item = new Item();
        $item->code = 'P28';
        $item->brand = 'PLASTIK 2X8';
        $item->save();


        $item = new Item();
        $item->code = 'P29';
        $item->brand = 'PLASTIK 2X9';
        $item->save();

        $item = new Item();
        $item->code = 'P37';
        $item->brand = 'PLASTIK 3X7';
        $item->save();
        $item = new Item();
        $item->code = 'P38';
        $item->brand = 'PLASTIK 3X8';
        $item->save();

        $item = new Item();
        $item->code = 'P39';
        $item->brand = 'PLASTIK 3X9';
        $item->save();

        $item = new Item();
        $item->code = 'P310';
        $item->brand = 'PLASTIK 3X10';
        $item->save();

        $item = new Item();
        $item->code = 'P311';
        $item->brand = 'PLASTIK 3X11';
        $item->save();

        $item = new Item();
        $item->code = 'P312';
        $item->brand = 'PLASTIK 3X12';
        $item->save();

        $item = new Item();
        $item->code = 'P225';
        $item->brand = 'PLASTIK 2X25';
        $item->save();


        $item = new Item();
        $item->code = 'P230';
        $item->brand = 'PLASTIK2X30';
        $item->save();


        $item = new Item();
        $item->code = 'P1224';
        $item->brand = 'PLASTIK 12X24';
        $item->save();


        $item = new Item();
        $item->code = 'P1830';
        $item->brand = 'PLASTIK 18X30';
        $item->save();


        $item = new Item();
        $item->code = 'KRESEK ( 25 )';
        $item->brand = 'KRESEK TANGGUNG 25';
        $item->save();


        $item = new Item();
        $item->code = 'KRESEK ( 28 )';
        $item->brand = 'KRESEK TANGGUNG 28';
        $item->save();

        $item = new Item();
        $item->code = 'KRESEK (32)';
        $item->brand = 'KRESEK TANGGUNG 32';
        $item->save();

        $role = new Vehicle();
        $role->name = 'Truk A';
        $role->type = "Truk";
        $role->save();

        $role = new Vehicle();
        $role->name = 'L-300 A';
        $role->type = "Pick Up";
        $role->save();
    }
}
