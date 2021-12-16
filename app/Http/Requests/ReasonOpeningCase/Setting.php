<?php

namespace App\Http\Requests\ReasonOpeningCase;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class Setting extends FormRequest
{
      /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
      return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
      return [
          'name' => 'required',Rule::unique('reason_opening_cases')->ignore($this->name, 'name'),
      ];
  }

}
