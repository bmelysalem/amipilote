<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
            // AMI Group
            ['groupe' => 'AMI', 'libelle' => 'COMMERCIAL', 'port_interne' => 7601, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => null, 'adresse_dns' => 'somelec.ami.akilee.tech/commercial', 'image_icon' => null, 'is_api' => false, 'admin_received' => false],
            ['groupe' => 'AMI', 'libelle' => 'COMMERCIAL API', 'port_interne' => 7002, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => '102.214.209.62', 'adresse_dns' => 'api.com.somelec.ami.akilee.tech', 'image_icon' => null, 'is_api' => true, 'admin_received' => true],
            ['groupe' => 'AMI', 'libelle' => 'DISTRIBUTION', 'port_interne' => 7602, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => null, 'adresse_dns' => 'somelec.ami.akilee.tech/distribution', 'image_icon' => null, 'is_api' => false, 'admin_received' => false],
            ['groupe' => 'AMI', 'libelle' => 'TRANSFO', 'port_interne' => 7004, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => null, 'adresse_dns' => 'api.transfo.somelec.ami.akilee.tech', 'image_icon' => null, 'is_api' => true, 'admin_received' => true],
            ['groupe' => 'AMI', 'libelle' => 'CORE', 'port_interne' => 7005, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => null, 'adresse_dns' => 'api.somelec.ami.akilee.tech', 'image_icon' => null, 'is_api' => true, 'admin_received' => false],
            ['groupe' => 'AMI', 'libelle' => 'SMARTVEND', 'port_interne' => 7603, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => null, 'adresse_dns' => 'smartvend.somelec.ami.akilee.tech', 'image_icon' => null, 'is_api' => false, 'admin_received' => false],
            ['groupe' => 'AMI', 'libelle' => 'VENDING ADMIN', 'port_interne' => 7604, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => null, 'adresse_dns' => 'somelec.ami.akilee.tech/smartvend', 'image_icon' => null, 'is_api' => false, 'admin_received' => true],
            ['groupe' => 'AMI', 'libelle' => 'VENDING API', 'port_interne' => 7006, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => 'IP_Publique+SSL_Client', 'adresse_dns' => 'api.vend.somelec.ami.akilee.tech', 'image_icon' => null, 'is_api' => true, 'admin_received' => true],
            // HES Group
            ['groupe' => 'HES', 'libelle' => 'DLMS MESSAGE', 'port_interne' => 18010, 'port_externe' => null, 'ip_interne' => null, 'ip_publique' => '102.214.209.62:18010', 'adresse_dns' => null, 'image_icon' => null, 'is_api' => false, 'admin_received' => false],
            ['groupe' => 'HES', 'libelle' => 'Clickhouse', 'port_interne' => 19000, 'port_externe' => 18123, 'ip_interne' => null, 'ip_publique' => null, 'adresse_dns' => null, 'image_icon' => null, 'is_api' => false, 'admin_received' => false],
            ['groupe' => 'HES', 'libelle' => 'Redis', 'port_interne' => 16379, 'port_externe' => 26379, 'ip_interne' => null, 'ip_publique' => null, 'adresse_dns' => null, 'image_icon' => null, 'is_api' => false, 'admin_received' => false],
            ['groupe' => 'HES', 'libelle' => 'Kafka-Zookeeper', 'port_interne' => 12181, 'port_externe' => 19092, 'ip_interne' => null, 'ip_publique' => null, 'adresse_dns' => null, 'image_icon' => null, 'is_api' => false, 'admin_received' => false],
            ['groupe' => 'HES', 'libelle' => 'DOREEN', 'port_interne' => null, 'port_externe' => null, 'ip_interne' => '10.10.20.104', 'ip_publique' => null, 'adresse_dns' => null, 'image_icon' => null, 'is_api' => false, 'admin_received' => false],
            ['groupe' => 'HES', 'libelle' => 'API', 'port_interne' => 18012, 'port_externe' => 18012, 'ip_interne' => '10.10.20.104', 'ip_publique' => '102.214.209.62', 'adresse_dns' => '/api/api.html', 'image_icon' => null, 'is_api' => true, 'admin_received' => true],
        ];

        DB::table('services')->insert($services);
    }
}
