<?php

namespace App\Orchid\Screens;

use App\Models\ChatRequest;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Actions\Button;

class ChatRequests extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(ChatRequest $request): array
    {
        return [
            'requests' => $request->where('ongoing', 1)->where('assigned_to', auth()->id())->get(),
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Chat Requests';
    }

        /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'List of chat requests';


    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

     /**
     * Button to accept the chat request.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function acceptChatRequest(int $id)
    {
        $request = ChatRequest::findOrFail($id);
        $request->ongoing = 1;
        $request->assigned_to = auth()->id();
        $request->save();

        Alert::success('Chat request accepted successfully!');

        return redirect()->to("chatify");
    }

    public function endChatRequest(int $id)
    {
        $request = ChatRequest::findOrFail($id);
        $request->ongoing = 2;
        $request->save();

        Alert::success('Chat request ended successfully!');

        return back();
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [
            // Layout::table('requests', [
            //     'User', 'Message', 'Status', ''
            // ])->column([
            //     'user.name' => 'User',
            //     'onging' => 'Status',
            //     '' => 'Actions'
            // ])->rows('requests', function ($request) {
            //     return [
            //         $request->user->name,
            //         $request->message,
            //         $request->status,
            //         $request->status !== 1 && $request->assigned_to === auth()->id()
            //             ? Button::make('Accept')
            //                 ->method('acceptChatRequest')
            //                 ->parameters(['id' => $request->id])
            //                 ->class('btn btn-success btn-sm')
            //             : Button::make('End Chat')
            //                 ->method('endChatRequest')
            //                 ->parameters(['id' => $request->id])
            //                 ->class('btn btn-danger btn-sm')
            //     ];
            // })
        ];
    }
}
