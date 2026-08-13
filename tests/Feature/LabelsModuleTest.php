<?php

use Bayurifkialghifari\WaxumApi\DTOs\Common\SuccessResponse;
use Bayurifkialghifari\WaxumApi\DTOs\Labels\CreateLabelRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Labels\MessageLabelRequest;
use Bayurifkialghifari\WaxumApi\DTOs\Labels\QuickReplyRequest;
use Bayurifkialghifari\WaxumApi\WaxumApiClient;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    $this->client = new WaxumApiClient('http://localhost:3451', 'test-token');
});

it('creates a label', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/labels' => Http::response([
            'success' => true,
            'label_id' => 'my-label-id',
        ]),
    ]);

    $response = $this->client->labels->createLabel('session-1', new CreateLabelRequest(
        labelId: 'my-label-id',
        name: 'My Label',
        colorId: 5,
    ));

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(function ($request) {
        $body = json_decode($request->body(), true);

        return $request->method() === 'POST'
            && $body['label_id'] === 'my-label-id'
            && $body['name'] === 'My Label'
            && $body['color_id'] === 5;
    });
});

it('deletes a label', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/labels/my-label-id' => Http::response([
            'success' => true,
        ]),
    ]);

    $response = $this->client->labels->deleteLabel('session-1', 'my-label-id');

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'DELETE');
});

it('adds a chat to a label', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/labels/my-label-id/chats/628123456789@s.whatsapp.net' => Http::response([
            'success' => true,
        ]),
    ]);

    $response = $this->client->labels->addChatToLabel('session-1', 'my-label-id', '628123456789@s.whatsapp.net');

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'POST');
});

it('removes a chat from a label', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/labels/my-label-id/chats/628123456789@s.whatsapp.net' => Http::response([
            'success' => true,
        ]),
    ]);

    $response = $this->client->labels->removeChatFromLabel('session-1', 'my-label-id', '628123456789@s.whatsapp.net');

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'DELETE');
});

it('adds a message to a label', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/labels/my-label-id/messages' => Http::response([
            'success' => true,
        ]),
    ]);

    $response = $this->client->labels->addMessageToLabel('session-1', 'my-label-id', new MessageLabelRequest(
        chatJid: '628123456789@s.whatsapp.net',
        messageId: 'ABCD1234',
        fromMe: true,
    ));

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(function ($request) {
        $body = json_decode($request->body(), true);

        return $request->method() === 'POST'
            && $body['chat_jid'] === '628123456789@s.whatsapp.net'
            && $body['message_id'] === 'ABCD1234'
            && $body['from_me'] === true;
    });
});

it('removes a message from a label', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/labels/my-label-id/messages/remove' => Http::response([
            'success' => true,
        ]),
    ]);

    $response = $this->client->labels->removeMessageFromLabel('session-1', 'my-label-id', [
        'chat_jid' => '628123456789@s.whatsapp.net',
        'message_id' => 'ABCD1234',
        'from_me' => true,
    ]);

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'POST');
});

it('upserts a quick reply', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/quick-replies' => Http::response([
            'success' => true,
            'id' => 'qr-id-1',
        ]),
    ]);

    $response = $this->client->labels->setQuickReply('session-1', new QuickReplyRequest(
        id: 'qr-id-1',
        shortcut: '/hello',
        message: 'Hello! How can I help?',
        keywords: ['hi', 'halo'],
        count: 0,
    ));

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(function ($request) {
        $body = json_decode($request->body(), true);

        return $request->method() === 'PUT'
            && $body['id'] === 'qr-id-1'
            && $body['shortcut'] === '/hello'
            && $body['keywords'] === ['hi', 'halo'];
    });
});

it('deletes a quick reply', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/quick-replies/qr-id-1' => Http::response([
            'success' => true,
        ]),
    ]);

    $response = $this->client->labels->deleteQuickReply('session-1', 'qr-id-1');

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'DELETE');
});

it('sets link previews setting', function () {
    Http::fake([
        'http://localhost:3451/api/v1/sessions/session-1/settings/link-previews' => Http::response([
            'success' => true,
            'disabled' => true,
        ]),
    ]);

    $response = $this->client->labels->setLinkPreviews('session-1', true);

    expect($response)->toBeInstanceOf(SuccessResponse::class)
        ->and($response->success)->toBeTrue();

    Http::assertSent(function ($request) {
        $body = json_decode($request->body(), true);

        return $request->method() === 'POST' && $body['disabled'] === true;
    });
});
