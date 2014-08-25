<?php
namespace BF\Component\Datagrid\Formatter;

use BF13\Component\Datagrid\Model\DatagridObject;

class Formatter
{
    public function __construct()
    {}

    public function format(DatagridObject $DataGrid)
    {
        $settings = $DataGrid->config->getColumns();

        $values = $DataGrid->column_values;

        $updated_values = array();

        foreach($settings as $sett)
        {
            $new_settings[$sett['ref']] = $sett;
        }

        foreach ($values as $row_id => $row) {
            $new_data = array();

            foreach ($row as $col => $data) {
                $action = 'Render' . ucfirst(strtolower($new_settings[$col]['type']));

                $new_data[$col] = $this->$action($data, $new_settings[$col]);
            }

            $values[$row_id] = $new_data;
        }

         $DataGrid->bind($values);
    }

    protected function RenderString($value, $options)
    {
        return (string) $value;
    }

    protected function RenderDate($value, $options)
    {
        return $value->format('Y-m-d');
    }

    protected function RenderDatetime($value, $options)
    {
        if(is_null($value))
        {
            return '';
        }

        return $value->format('Y-m-d');
    }

    protected function RenderAttribute_entity($value, $options)
    {
        return $value;
    }

    protected function RenderAttribute_object($value, $options)
    {
        if(! $value)
        {
            return;
        }

        return $value->$options['source'];
    }

    protected function RenderValue_list($value, $options)
    {
        return $value;
    }
}