<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TCG\Voyager\Models\DataRow;
use TCG\Voyager\Models\DataType;
use TCG\Voyager\Models\Menu;
use TCG\Voyager\Models\MenuItem;
use TCG\Voyager\Models\Permission;

class InvoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataType = $this->dataType('slug', 'invoices');
        if (!$dataType->exists) {
            $dataType->fill([
                'name'                  => 'invoices',
                'display_name_singular' => 'Factura',
                'display_name_plural'   => 'Facturas',
                'icon'                  => 'voyager-receipt',
                'model_name'            => 'App\\Models\\Invoice',
                'generate_permissions'  => 1,
                'description'           => '',
            ])->save();
        }

        $menu = Menu::where('name', 'admin')->firstOrFail();

        $menuItem = MenuItem::firstOrNew([
            'menu_id' => $menu->id,
            'title'   => 'Facturas',
            'url'     => '',
            'route'   => 'voyager.invoices.index',
        ]);
        if (!$menuItem->exists) {
            $menuItem->fill([
                'target'     => '_self',
                'icon_class' => 'voyager-receipt',
                'color'      => null,
                'parent_id'  => null,
                'order'      => 130,
            ])->save();
        }



        $keys = ['browse_invoices', 'read_invoices', 'edit_invoices', 'add_invoices', 'delete_invoices'];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key'        => $key,
                'table_name' => 'invoices',
            ]);
        }

        Permission::generateFor('invoices');


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

        $dataRow = $this->dataRow($dataType, 'date');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'date',
                'display_name' => 'Fecha',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count,
            ])->save();
        }


        $dataRow = $this->dataRow($dataType, 'client_id');
        if (!$dataRow->exists) {
            $dataRow->fill([
                'type'         => 'number',
                'display_name' => 'client_id',
                'required'     => 1,
                'browse'       => 1,
                'read'         => 1,
                'edit'         => 1,
                'add'          => 1,
                'delete'       => 1,
                'order'        => $count,
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
