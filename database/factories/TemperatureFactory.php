<?php

namespace Database\Factories;

use App\Models\Temperature;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TemperatureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Temperature::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $topLimit = 0;
        $bottomLimit = 0;
        $ranNumOne = $this->faker->randomFloat(1, 5, 50);
        $ranNumTwo = $this->faker->randomFloat(1, 5, 50);

        if ($ranNumOne == $ranNumTwo)
        {
            $ranNumTwo += 1;
        }

        if ($ranNumOne > $ranNumTwo)
        {
            $topLimit = $ranNumOne;
            $bottomLimit = $ranNumTwo;
        }
        else
        {
            $topLimit = $ranNumTwo;
            $bottomLimit = $ranNumOne;
        }

        return [
            'recorded' => $this->faker->randomFloat(1, $bottomLimit, $topLimit),
            'recorded_at' => Carbon::now()->toDateTimeLocalString(),
            'topLimit' => $topLimit,
            'bottomLimit' => $bottomLimit,
            'device_id' => 1,
        ];
    }
}
