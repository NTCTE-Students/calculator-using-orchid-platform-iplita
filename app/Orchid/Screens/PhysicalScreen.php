<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\TD;

class PhysicalScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'history' => session()->get('history_ph', []),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Калькулятор физических величин';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Считать')
                ->icon('calculator')
                ->method('calculate')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Select::make('operation_1')
                    ->options([
                        'мм' => 'мм',
                        'см' => 'см',
                        'дм' => 'дм',
                        'м' => 'м',
                        'км' => 'км',
                        'дюйм' => 'дюйм',
                    ])
                    ->title('Изначальная физическая величина'),
                Input::make('b')
                    ->type('number')
                    ->title('Значение'),
                Select::make('operation_2')
                    ->options([
                        'мм' => 'мм',
                        'см' => 'см',
                        'дм' => 'дм',
                        'м' => 'м',
                        'км' => 'км',
                        'дюйм' => 'дюйм',
                    ])
                    ->title('Конечная физическая величина'),
            ]),
            Layout::table('history', [
                TD::make('type', 'Из какой в какую величины')
                    -> render(fn($operation) => $operation['start'] . '->' . $operation['end']),
                TD::make('znach', 'Значение')
                    -> render(fn($operation) => $operation['b']),
                TD::make('result', 'Результат')
                    -> render(fn($operation) => $operation['result']),
            ]),
        ];
    }

    public function calculate(Request $request)
    {
        $b = $request->get('b');
        $start = $request->get('operation_1');
        $end = $request->get('operation_2');
        $result = 0;

        switch($start)
        {
            case 'мм':
            {
                switch($end)
                {
                    case 'мм':
                    {
                        $result = $b;
                        break;
                    }
                    case 'см':
                    {
                        $result = $b / 10;
                        break;
                    }
                    case 'дм':
                    {
                        $result = $b / 100;
                        break;
                    }
                    case 'м':
                    {
                        $result = $b / 1000;
                        break;
                    }
                    case 'км':
                    {
                        $result = $b / 1000000;
                        break;
                    }
                    case 'дюйм':
                    {
                        $result = $b / 25.4;
                        break;
                    }
                }
                break;
            }
            case 'см':
            {
                switch($end)
                {
                    case 'мм':
                    {
                        $result = $b * 10;
                        break;
                    }
                    case 'см':
                    {
                        $result = $b;
                        break;
                    }
                    case 'дм':
                    {
                        $result = $b / 10;
                        break;
                    }
                    case 'м':
                    {
                        $result = $b / 100;
                        break;
                    }
                    case 'км':
                    {
                        $result = $b / 100000;
                        break;
                    }
                    case 'дюйм':
                    {
                        $result = $b / 2.54;
                        break;
                    }
                }
                break;
            }
            case 'дм':
            {
                switch($end)
                {
                    case 'мм':
                    {
                        $result = $b * 100;
                        break;
                    }
                    case 'см':
                    {
                        $result = $b * 10;
                        break;
                    }
                    case 'дм':
                    {
                        $result = $b;
                        break;
                    }
                    case 'м':
                    {
                        $result = $b / 10;
                        break;
                    }
                    case 'км':
                    {
                        $result = $b / 10000;
                        break;
                    }
                    case 'дюйм':
                    {
                        $result = $b / 2.54;
                        break;
                    }
                }
                break;
            }
            case 'м':
            {
                switch($end)
                {
                    case 'мм':
                    {
                        $result = $b * 1000;
                        break;
                    }
                    case 'см':
                    {
                        $result = $b * 100;
                        break;
                    }
                    case 'дм':
                    {
                        $result = $b * 10;
                        break;
                    }
                    case 'м':
                    {
                        $result = $b;
                        break;
                    }
                    case 'км':
                    {
                        $result = $b / 1000;
                        break;
                    }
                    case 'дюйм':
                    {
                        $result = $b / 0.0254;
                        break;
                    }
                }
                break;
            }
            case 'км':
            {
                switch($end)
                {
                    case 'мм':
                    {
                        $result = $b * 1000000;
                        break;
                    }
                    case 'см':
                    {
                        $result = $b * 100000;
                        break;
                    }
                    case 'дм':
                    {
                        $result = $b * 10000;
                        break;
                    }
                    case 'м':
                    {
                        $result = $b * 1000;
                        break;
                    }
                    case 'км':
                    {
                        $result = $b;
                        break;
                    }
                    case 'дюйм':
                    {
                        $result = $b / 0.0000254;
                        break;
                    }
                }
                break;
            }
            case 'дюйм':
            {
                switch($end)
                {
                    case 'мм':
                    {
                        $result = $b * 25.4;
                        break;
                    }
                    case 'см':
                    {
                        $result = $b * 2.54;
                        break;
                    }
                    case 'дм':
                    {
                        $result = $b * 2.54;
                        break;
                    }
                    case 'м':
                    {
                        $result = $b * 0.0254;
                        break;
                    }
                    case 'км':
                    {
                        $result = $b * 0.0000254;
                        break;
                    }
                    case 'дюйм':
                    {
                        $result = $b;
                        break;
                    }
                }
                break;
            }
        }


        $request->session()->push('history_ph', [
            'start' => $start,
            'end' => $end,
            'b' => $b,
            'result' => $result,
        ]);
        return back()->with('result', $result);
    }
}
