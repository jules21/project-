<?php

namespace App\Http\Controllers\Web;

use Cache;
use App\Http\Controllers\Controller;
use App\Result;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Input;
use App\Support\Enum\UserStatus;

use App\Repositories\Result\ResultRepository;
use App\Http\Requests\Result\CreateResultRequest;
use App\Http\Requests\Result\UpdateResultRequest;

class ResultsController extends Controller
{
    private $results;

    public function __construct(ResultRepository $results)
    {
        $this->middleware('auth');
        $this->middleware('permission:results.manage');
        $this->results = $results;
    }

    public function index()
    {
        $results = $this->results->paginate(
            $perPage = 20,
            Input::get('search'),
            Input::get('status')
        );

        return view('result.index', compact('results'));
    }

    public function create()
    {
        $edit = false;
        return view('result.add-edit', compact('edit', 'departments'));
    }

    public function store(CreateResultRequest $request)
    {
        $this->results->create($request->all());

        return redirect()->route('result.index')
            ->withSuccess('Result created');
    }

    public function edit(Result $result)
    {
        $edit = true;
        return view('result.add-edit', compact('edit', 'result'));
    }

    public function update(Result $result, UpdateResultRequest $request)
    {
        $this->results->update($result->id, $request->all());

        return redirect()->route('result.index')
            ->withSuccess('Result updated');
    }

    public function delete(Result $result)
    {
        // if (! $result->removable) {
        //     throw new NotFoundHttpException;
        // }

        $this->results->delete($result->id);

        Cache::flush();

        return redirect()->route('result.index')
            ->withSuccess('Result deleted');
    }
}