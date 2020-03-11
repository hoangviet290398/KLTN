<?php

namespace App\Http\Controllers;
use App\Answer;
use Illuminate\Http\Request;
use App\Question;
use App\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use App\Http\Requests\AnswerRequest;
use Illuminate\Support\Facades\Storage;

class AnswerController extends Controller
{
	private $typeFiles = array('application/x-rar-compressed', 'application/octet-stream', 'application/zip', 'application/x-rar', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
	private $startIdEdit = 33;
	private $startIdAdd = 28;

	public function store(AnswerRequest $request)
	{
		$id = substr($request->header('referer'),$this->startIdAdd);
		$question= Question::find("$id");
		$question->total_answer+=1;
		$question->save();

		$answer = new Answer();
		$answer->content = $request->get('content');
		$answer->user()->associate(Auth::user());
		$answer->question()->associate($question);
		$answer->total_like = 0;
		$answer->total_dislike = 0;
		$answer->attachment_path = null;
		$answer->save();

		if($request->hasFile('attachment')) {
			$typeFiles = $this->typeFiles;
			$typeFileAttachment = $request->attachment->getMimeType();
				if(in_array($typeFileAttachment, $typeFiles)) {

					$filename = $answer->_id.'.'.$request->attachment->getClientOriginalExtension();
					$answer->attachment_path = $filename;
					Storage::putFileAs('public/files/', $request->attachment, $filename);
					$answer->save();
				} else {
					session()->flash('errorUpload', 'Files only support ZIP and RAR formats');
					
					return redirect()->back();
				}
		}

		if(Auth::user()->id == $question->user->id)
		{
			return redirect()->route('viewTopic', ['id' => $answer->question_id]);
		}

		(new UserController)->createNotification($question->user, Notification::$target['question'], Notification::$action['answer'],  $question->_id);

		return redirect()->route('viewTopic', ['id' => $answer->question_id]);
	}

	public function edit($id)
	{
	
		$answer = Auth::user()->answers()->find($id);
		if(empty($answer)) {
			return redirect()->back();
		} 
		$question = $answer->question;
		$parsedown = new \Parsedown();
		$question->content = $parsedown->setMarkupEscaped(true)->text($question->content);

		return view('answer.edit_answer',compact('answer','id','question'));
	}

	public function update(AnswerRequest $request)
	{
		$id = substr($request->header('referer'),$this->startIdEdit);
		$answer = Answer::find($id);
		$answer->content = $request->get('content');
		if($request->hasFile('attachment')) {
			Storage::delete('public/files/'.$answer->attachment_path);
			$typeFiles = $this->typeFiles;
			$typeFileAttachment = $request->attachment->getMimeType();
			if(in_array($typeFileAttachment, $typeFiles)) {
				$filename = $answer->_id.'.'.$request->attachment->getClientOriginalExtension();
				$answer->attachment_path = $filename;
				Storage::putFileAs('public/files/', $request->attachment, $filename);
			} else {
				session()->flash('errorUpload', 'Files only support ZIP and RAR formats');

				return redirect()->back();
			}
		}
		$answer->save();

		return redirect()->route('viewTopic', ['id' => $answer->question_id]);
	}
}
