<?php

namespace Webkul\Admin\Http\Controllers\TermAndCondition;
use Webkul\Admin\Http\Controllers\Controller;
use DB;

class TermAndConditionController extends Controller {
    // CRUD TERM AND CONDITION >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    public function create()
    {
        DB::table('term_and_conditions')->insert([
            'template' => request()->template,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return response()->json(['message' => 'Success Create Data']);
    }

    public function update($id)
    {
        DB::table('term_and_conditions')->where('id', request()->id)->update([
            'template' => request()->template,
            'updated_at' => now()
        ]);
        return response()->json(['message' => 'Success Edit Data']);
    }

    public function delete($id)
    {
        DB::table('term_and_conditions')->where('id', request()->id)->delete();
        return response()->json(['message' => 'Success Delete Data']);
    }
}
