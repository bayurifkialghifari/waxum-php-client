<?php

use Bayurifkialghifari\WaxumApi\DTOs\ChatState\ChatStateType;
use Bayurifkialghifari\WaxumApi\DTOs\ChatState\SendChatStateRequest;
use Bayurifkialghifari\WaxumApi\DTOs\ChatState\SendTypingRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->client = new WaxumApiClient('http://localhost:3451', 'test-token');
});

it('sends chat state with DTO', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/chatstate/send' => Http::response([
            'success' => true,
            'message' => 'Chat state sent',
        ]),
    ]);

    $request = new SendChatStateRequest(
        to: '628123456789@s.whatsapp.net',
        state: ChatStateType::COMPOSING
    );

    $response = $this->client->chatstate->sendChatState('session-1', $request);

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue()
        ->and($response->message)->toBe('Chat state sent');

    Http::assertSent(function ($request) {
        return $request->url() === 'http://localhost:3451/api/v1/sessions/session-1/chatstate/send'
            && $request['to'] === '628123456789@s.whatsapp.net'
            && $request['state'] === 'composing';
    });
});

it('sends chat presence alias with array payload', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/chatstate/send' => Http::response([
            'success' => true,
            'message' => 'Chat state sent',
        ]),
    ]);

    $response = $this->client->chatstate->sendChatPresence('session-1', [
        'to' => '628123456789@s.whatsapp.net',
        'state' => 'recording',
    ]);

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(function ($request) {
        return $request['state'] === 'recording';
    });
});

it('sends typing indicator with DTO including duration', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/chatstate/typing' => Http::response([
            'success' => true,
            'message' => 'Typing sent',
        ]),
    ]);

    $request = new SendTypingRequest(
        to: '628123456789@s.whatsapp.net',
        duration: 3000
    );

    $response = $this->client->chatstate->sendTyping('session-1', $request);

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(function ($request) {
        return $request->url() === 'http://localhost:3451/api/v1/sessions/session-1/chatstate/typing'
            && $request['to'] === '628123456789@s.whatsapp.net'
            && $request['duration'] === 3000;
    });
});

it('sends typing indicator with string to and duration parameter', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/chatstate/typing' => Http::response([
            'success' => true,
            'message' => 'Typing sent',
        ]),
    ]);

    $response = $this->client->chatstate->sendTyping('session-1', '628123456789@s.whatsapp.net', 3000);

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(function ($request) {
        return $request['to'] === '628123456789@s.whatsapp.net'
            && $request['duration'] === 3000;
    });
});
