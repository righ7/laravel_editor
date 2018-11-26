<?php

namespace App\Admin\Requests;

use App\Http\Requests\Request;

/**
 * Class UserApiRequest
 * @package App\Application\Article\Requests\Article
 */
class BaseApiRequest extends Request
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
            //
        ];
    }
}
