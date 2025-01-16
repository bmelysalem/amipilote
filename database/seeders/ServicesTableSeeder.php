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
        DB::table('services')->insert([
            ['groupe' => 'AMI', 'libelle' => 'COMMERCIAL', 'port_interne' => 7601, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => null, 'adresse_dns' => 'somelec.ami.akilee.tech/commercial'],
            ['groupe' => 'AMI', 'libelle' => 'COMMERCIAL API', 'port_interne' => 7002, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => '102.214.209.62', 'adresse_dns' => 'api.com.somelec.ami.akilee.tech'],
            ['groupe' => 'AMI', 'libelle' => 'DISTRIBUTION', 'port_interne' => 7602, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => null, 'adresse_dns' => 'somelec.ami.akilee.tech/distribution'],
            ['groupe' => 'AMI', 'libelle' => 'TRANSFO', 'port_interne' => 7004, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => null, 'adresse_dns' => 'api.transfo.somelec.ami.akilee.tech'],
            ['groupe' => 'AMI', 'libelle' => 'CORE', 'port_interne' => 7005, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => null, 'adresse_dns' => 'api.somelec.ami.akilee.tech'],
            ['groupe' => 'AMI', 'libelle' => 'SMARTVEND', 'port_interne' => 7603, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => null, 'adresse_dns' => 'smartvend.somelec.ami.akilee.tech'],
            ['groupe' => 'AMI', 'libelle' => 'VENDING ADMIN', 'port_interne' => 7604, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => null, 'adresse_dns' => 'somelec.ami.akilee.tech/smartvend'],
            ['groupe' => 'AMI', 'libelle' => 'VENDING API', 'port_interne' => 7006, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => 'IP_Publique+SSL_Client', 'adresse_dns' => 'api.vend.somelec.ami.akilee.tech'],
            ['groupe' => 'AMI', 'libelle' => 'GDU', 'port_interne' => 7605, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => null, 'adresse_dns' => 'somelec.ami.akilee.tech/gdu'],
            ['groupe' => 'AMI', 'libelle' => 'AMIOPS FRONT', 'port_interne' => 4600, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => null, 'adresse_dns' => 'ops.somelec.ami.akilee.tech'],
            ['groupe' => 'AMI', 'libelle' => 'AMIOPS API', 'port_interne' => 4000, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => '102.214.209.62', 'adresse_dns' => 'api.ops.somelec.ami.akilee.tech'],
            ['groupe' => 'AMI', 'libelle' => 'BASTION API', 'port_interne' => 7007, 'port_externe' => null, 'ip_interne' => '10.10.30.101', 'ip_publique' => null, 'adresse_dns' => '-'],
            ['groupe' => 'AMI', 'libelle' => 'AUTH', 'port_interne' => 8001, 'port_externe' => null, 'ip_interne' => '10.10.30.101', 'ip_publique' => null, 'adresse_dns' => 'api.auth.somelec.ami.akilee.tech'],
            ['groupe' => 'AMI', 'libelle' => 'MESSAGERIE', 'port_interne' => 3001, 'port_externe' => null, 'ip_interne' => '10.10.30.101', 'ip_publique' => null, 'adresse_dns' => 'api.msg.somelec.ami.akilee.tech'],
            ['groupe' => 'AMI', 'libelle' => 'RUNDECK', 'port_interne' => 4440, 'port_externe' => null, 'ip_interne' => '10.10.30.102', 'ip_publique' => null, 'adresse_dns' => 'rundeck.somelec.ami.akilee.tech'],
            ['groupe' => 'AMI', 'libelle' => 'METABASE', 'port_interne' => 3000, 'port_externe' => null, 'ip_interne' => '10.10.30.104', 'ip_publique' => null, 'adresse_dns' => 'metabase.somelec.ami.akilee.tech'],
            ['groupe' => 'AMI', 'libelle' => 'JASPERREPORTS', 'port_interne' => 8080, 'port_externe' => null, 'ip_interne' => '10.10.30.104', 'ip_publique' => null, 'adresse_dns' => '-'],
            ['groupe' => 'AMI', 'libelle' => 'Mur D image', 'port_interne' => 7606, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => null, 'adresse_dns' => 'wall.somelec.ami.akilee.tech'],
            ['groupe' => 'AMI', 'libelle' => 'Mu d image API', 'port_interne' => 7010, 'port_externe' => null, 'ip_interne' => '10.10.30.100', 'ip_publique' => null, 'adresse_dns' => 'api.wall.somelec.ami.akilee.tech'],
            ['groupe' => 'AMI', 'libelle' => 'Interface', 'port_interne' => 7007, 'port_externe' => null, 'ip_interne' => '10.10.30.119', 'ip_publique' => null, 'adresse_dns' => '-'],
            ['groupe' => 'HES', 'libelle' => 'HES', 'port_interne' => null, 'port_externe' => null, 'ip_interne' => '10.10.20.101/10.10.20.102/10.10.20.103', 'ip_publique' => null, 'adresse_dns' => '-'],
            ['groupe' => 'HES', 'libelle' => 'DLMS MESSAGE', 'port_interne' => 18010, 'port_externe' => null, 'ip_interne' => '-', 'ip_publique' => '102.214.209.62:18010', 'adresse_dns' => '-'],
            ['groupe' => 'HES', 'libelle' => 'Clickhouse', 'port_interne' => '19000;18123', 'port_externe' => null, 'ip_interne' => '-', 'ip_publique' => null, 'adresse_dns' => '-'],
            ['groupe' => 'HES', 'libelle' => 'Redis', 'port_interne' => '16379;26379', 'port_externe' => null, 'ip_interne' => '-', 'ip_publique' => null, 'adresse_dns' => '-'],
            ['groupe' => 'HES', 'libelle' => 'Kafka-Zookeeper', 'port_interne' => '12181;19092', 'port_externe' => null, 'ip_interne' => '-', 'ip_publique' => null, 'adresse_dns' => '-'],
            ['groupe' => 'HES', 'libelle' => 'DOREEN', 'port_interne' => null, 'port_externe' => null, 'ip_interne' => '10.10.20.104', 'ip_publique' => null, 'adresse_dns' => '-'],
            ['groupe' => 'HES', 'libelle' => 'MDMS', 'port_interne' => 80, 'port_externe' => null, 'ip_interne' => '10.10.20.104', 'ip_publique' => null, 'adresse_dns' => '-'],
            ['groupe' => 'HES', 'libelle' => 'xxl-job Admin', 'port_interne' => 10084, 'port_externe' => null, 'ip_interne' => '10.10.20.104', 'ip_publique' => null, 'adresse_dns' => '-'],
            ['groupe' => 'HES', 'libelle' => 'FTPServer', 'port_interne' => 12020, 'port_externe' => null, 'ip_interne' => '10.10.20.104', 'ip_publique' => null, 'adresse_dns' => '-'],
            ['groupe' => 'HES', 'libelle' => 'MySQL', 'port_interne' => 13306, 'port_externe' => null, 'ip_interne' => '10.10.20.104', 'ip_publique' => null, 'adresse_dns' => '-'],
            ['groupe' => 'HES', 'libelle' => 'API', 'port_interne' => 18012, 'port_externe' => 18012, 'ip_interne' => '10.10.20.104', 'ip_publique' => '102.214.209.62', 'adresse_dns' => '/api/api.html']
        ]);
    }
}
