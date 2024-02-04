<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class PhonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataType = $this->dataType('slug', 'phones');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'phones',
                'display_name_singular' => 'Teléfono',
                'display_name_plural'   => 'Teléfonos',
                'icon'                  => 'voyager-phone',
                'model_name'            => 'App\\Models\\Phone',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        $menu = Menu::where('name', 'admin')->firstOrFail();

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'Teléfonos',
            'url'     => '',
            'route'   => 'voyager.phones.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-phone',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 110,
            ])->save();
        }


        $keys = ['browse_phones', 'read_phones', 'edit_phones', 'add_phones', 'delete_phones'];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => 'phones',
            ]);
        }

        Permission::generateFor('phones');


        $count = 1;

        $dataRow = $this->dataRow($dataType, 'id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => 'id',
                'required'     => 1,
                'browse'       => 0,
                'read'         => 0,
                'edit'         => 0,
                'add'          => 0,
                'delete'       => 0,
                'order'        => $count,
            ])->save();
        }


        $dataRow = $this->dataRow($dataType, 'number');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'Número',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count++,
            ])->save();
        }


        $dataRow = $this->dataRow($dataType, 'cliente');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'relationship',
                'display_name' => 'Cliente',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count++,
                'details' => [
                    'model'       => 'App\\Models\\Client',
                    'table'       => 'clients',
                    'type'        => 'belongsTo',
                    'column'      => 'client_id',
                    'key'         => 'id',
                    'label'       => 'name',
                ]
            ])->save();
        }

        $dataRow = $this->dataRow($dataType, 'state');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'checkbox',
                'display_name' => 'Estado',
                'required'     => 0,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count++,
            ])->save();
        }

        $dataRow = $this->dataRow($dataType, 'client_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'text',
                'display_name' => 'cliente_id',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count++
            ])->save();
        }



    }

    protected function dataType($field, $for)
    {
        return DataType::firstOrNew([$field => $for]);
    }

    protected function dataRow($type, $field)
    {
        return DataRow::firstOrNew([
            'data_type_id' => $type->id,
            'field'        => $field,
        ]);
    }
}
