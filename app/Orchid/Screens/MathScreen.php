<?php

namespace App\Orchid\Screens;

use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Select;
use Illuminate\Http\Request;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;

class MathScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'history' => session()->get('history', []),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Калькулятор';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [
            Button::make('Вычислить')
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
                Input::make('first')
                    ->type('number')
                    ->required()
                    ->title('Первое число'),

                Input::make('second')
                    ->type('number')
                    ->title('Второе число'),

                Select::make('operation')
                    ->options([
                        '+' => 'Сложение',
                        '-'=> 'Вычитание',
                        '*'=> 'Умножение',
                        '/'=> 'Деление',
                        '%'=> 'Остаток от деления',
                        '//'=> 'Целочисленное деление',
                        '**'=> 'Возведение в степень',
                        '√s'=> 'Квадратный корень',
                        'log'=> 'Логарифм',
                        'sin'=> 'Синус',
                        'cos'=> 'Косинус',
                        'tan'=> 'Тангенс',
                    ])
                    ->title('Выберите операцию'),
            ]),
            Layout::table('history', [
                TD::make('dd', 'Действие')
                    -> render(fn($operation) => $operation['first'] . $operation['operation'] . $operation['second']),
                TD::make('result', 'Результат')
                    -> render(fn($operation) => $operation['result']),
            ]),
        ];
    }

    public function calculate(Request $request)
    {
        $first = $request->get('first');
        $second = $request->get('second');
        $operation = $request->get('operation');
        $result = 0;

        switch ($operation) {
            case '+':
                $result = $first + $second;
                break;
            case '-':
                $result = $first - $second;
                break;
            case '*':
                $result = $first * $second;
                break;
            case '/':
                if ($second != 0) {
                    $result = $first / $second;
                } else {
                    return 'На ноль делить нельзя';
                }
                break;
            case '%':
                $result = $first % $second;
                break;
            case '//':
                $result = intdiv($first, $second);
                break;
            case '**':
                $result = $first ** $second;
                break;
            case '√':
                $result = sqrt($first);
                break;
            case 'log':
                $result = log($first);
                break;
            case'sin':
                $result = sin($first);
                break;
            case 'cos':
                $result = cos($first);
                break;
            case 'tan':
                $result = tan($first);
                break;
        }
        $request->session()->push('history', [
            'operation' => $operation,
            'first' => $first,
            'second' => $second,
            'result' => $result,
        ]);
        return back()->with('result', $result);
    }
}
