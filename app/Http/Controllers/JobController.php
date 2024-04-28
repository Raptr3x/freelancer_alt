<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    
    /**
     * Display a listing of the jobs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $resp = ['jobs' => DB::table('jobs')->select('id', 'title', 'description', 'metadata', 'user_id')->where('deleted', 0)->get()];
        } catch (\Exception $e) {
            $resp = [
                'error' => 'An error occurred while fetching jobs',
                'message' => $e->getMessage()
            ];
        }

        return response()->json($resp);

    }

    /**
     * Display the specified job.
     *
     * @param  int  $job_id
     * @return \Illuminate\Http\Response
     */
    public function show($job_id)
    {
        try {
            $resp = ['job' => DB::table('jobs')->where('id', $job_id)->first()];
            if($resp['job'] == null) {
                $resp = ['error' => 'job ' . $job_id . ' not found'];
            }
        } catch (\Exception $e) {
            $resp = [
                'error' => 'An error occurred while fetching job ' . $job_id,
                'message' => $e->getMessage()
            ];
        }

        return response()->json($resp);
    }

    /**
     * Store a newly created job in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $job = [
                'title' => $request->title,
                'description' => $request->description,
                'metadata' => $request->metadata,
                'user_id' => $request->user_id
            ];
            
            if (DB::table('jobs')->insert($job)) {
                $resp = [
                    'message' => 'job created successfully',
                    'job_id' => DB::getPdo()->lastInsertId()
                ];
            } else {
                $resp = ['error' => 'Failed to create job'];
            }

        } catch (\Exception $e) {
            $resp = [
                'error' => 'An error occurred while creating job',
                'message' => $e->getMessage()
            ];
        }

        return response()->json($resp);
    }

    /**
     * Update the specified job in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $job_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $job = [
            'title' => $request->title,
            'description' => $request->description,
            'metadata' => $request->metadata,
            'user_id' => $request->user_id,
            'deleted' => $request->deleted
        ];

        if(DB::table('jobs')->where('id', $request->job_id)->update($job)){
            $resp = [
                'message' => 'job ' . $request->job_id . ' updated successfully'
            ];
        } else {
            $resp = [
                'error' => 'Failed to update job ' . $request->job_id
            ];
        }

        return response()->json($resp);
    }

    /**
     * Delete the specified job from storage.
     *
     * @param  int  $job_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($job_id)
    {
        try {
            $job = DB::table('jobs')->where('id', $job_id)->first();
            if($job == null) {
                $resp = ['error' => 'job ' . $job_id . ' not found'];
            }
            DB::table('jobs')->where('id', $job_id)->delete();
            
            $resp = [
                'message' => 'job ' . $job_id . ' deleted successfully'
            ];
        } catch (\Exception $e) {
            $resp = [
                'error' => 'An error occurred while deleting job ' . $job_id,
                'message' => $e->getMessage()
            ];
        }

        return response()->json($resp);
    }
}
