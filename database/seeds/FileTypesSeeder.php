<?php

use Illuminate\Database\Seeder;
use App\Models\Ftype;
use App\Models\Fext;
use App\Models\FtypeHasFext;

class FileTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->command->info('disabling foreignkeys check');
        Schema::disableForeignKeyConstraints();
        $this->command->info('truncating file_type_has_extension...');
        DB::table('ftypes')->truncate();
        $this->command->info('truncating fext...');
        DB::table('fexts')->truncate();
        Schema::enableForeignKeyConstraints();
        
        $files = [
            'image' => [
                'extension' => [
                    'jpg',
                    'jpeg',
                    'png',
                ]
            ],
            'video' => [
                'extension' => [
                    'mp4',
                ]
            ],
            'audio' => [
                'extension' => [
                    'mp3',
                    'wav'
                ]
            ],
            'document' => [
                'extension' => [
                    'pdf',
                    'xls',
                    'xlsx',
                    'doc',
                    'docx'
                ]
            ],
            'app' => [
                'extension' => [
                    'apk',
                    'ipa',
                ]
            ],
        ];
        foreach ($files as $key => $value) {
            $this->command->info('creating fileType '.$key);
            $fileType = Ftype::create([
                'name'  => $key
            ]);
            $fileType = Ftype::find($fileType->id);

            foreach ($value['extension'] as $extension) {
                $this->command->info('creating fileExtension '.$extension);
                $fileExtension = Fext::create([
                    'name'    => $extension,
                    'ftype_id'=> $fileType->id
                ]);
            }
        }
    }
}
