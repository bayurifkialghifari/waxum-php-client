# Changelog

All notable changes to `waxum-php-client` will be documented in this file.

## 2.0.0 - 2026-08-14

Full parity with the waxum gateway API (0.12.0 + latest upstream sync): ~60
previously-missing endpoints, 6 new modules, and webhook signature verification.

### ⚠️ Breaking changes

**`MediaModule::upload()` signature changed.** The old JSON body form never
worked against the server — uploads are `multipart/form-data`.

```php
// before (1.x) — never succeeded server-side
WaxumApi::media()->upload($sessionId, ['file' => $base64], $token);

// after (2.0)
WaxumApi::media()->upload($sessionId, '/path/to/file.jpg', 'image', 'image/jpeg', $token);
```

Note `$token` moved from the 3rd to the 5th parameter.

**`WebhookEventType::KEEP_ALIVE_TIMEOUT` removed.** The gateway no longer emits
`keep_alive_timeout`; referencing the case is now a fatal error. Use
`WebhookEventType::DISCONNECTED` or the new `STREAM_ERROR` instead.

**New properties inserted into DTO constructors.** Positional construction of
these DTOs will now bind the wrong arguments — use named arguments:

| DTO | Added |
|---|---|
| `DTOs\Common\SendTextRequest` | `$mentionAll`, `$mentions` (positions 2–3) |
| `DTOs\Session\SessionStatusResponse` | `$paused` (position 3), `$socketAlive` (position 6) |
| `DTOs\Session\CreateSessionRequest` | `$reuse` (before `$webhook`) |

```php
// before — positional, now binds to the wrong properties
new SendTextRequest(null, 'msg-id', null, 'Hello', '628...@s.whatsapp.net');

// after — named arguments are stable across releases
new SendTextRequest(replyTo: 'msg-id', text: 'Hello', to: '628...@s.whatsapp.net');
```

### Added

- **Webhook signature verification** — `WebhookSignature::verify()` and
  `WebhookSignature::fromRequest()` implement the v2 scheme
  (`HMAC-SHA256("{timestamp}.{body}")`, `sha256=` prefix, `hash_equals`,
  300 s anti-replay tolerance). The package previously shipped none.
- **`FleetModule`** (`WaxumApi::fleet()`) — `info()`, `stats()`,
  `reenableAllWebhooks()`, `health()`, `live()`, `ready()`.
- **`TokensModule`** (`WaxumApi::tokens()`) — `mint()`, `list()`, `revoke()`.
- **`TagsModule`** (`WaxumApi::tags()`) — `list()`, `forSession()`,
  `setTags()`, `add()`, `remove()`.
- **`LabelsModule`** (`WaxumApi::labels()`) — label CRUD, chat/message label
  assignment, quick replies, link-preview toggle.
- **`BusinessModule`** (`WaxumApi::business()`) — `catalog()`, `collections()`,
  `order()`, `updateProfile()`, `deleteCoverPhoto()`.
- **`BotsModule`** (`WaxumApi::bots()`) — `bots()`, `capping()`.
- `SessionModule`: `pause()`, `resume()`, `resyncAppState()` (with
  `AppStateResyncMode` enum), `purge()`, `disconnectAll()`, `reconnectAll()`,
  `search()`, `export()` (ZIP, with `SessionExport::saveAs()`), `import()`.
- `MessageModule`: 9 additional send types, plus `listChatMessages()` and
  `listMessages()` (session-wide cursor paging via `nextCursor`).
- `CallsModule`: `voices()`, `ttsPreview()`, `recording()`, `transcript()`.
- `NewsletterModule`: 11 management endpoints.
- `WebhookModule`: `listDlq()` and `replayDlq()` for the dead-letter queue.
- `SendTextRequest`: `mentions[]` and `mentionAll`.
- `CreateSessionRequest`: `reuse`.
- `SessionStatusResponse`: `socketAlive`, `paused`.
- `WebhookEventType`: `ACCOUNT_LOCKED`, `CALL_LOG_SYNC`, `STREAM_ERROR`,
  `ENC_DECRYPT_FAILED`.
- `WaxumApiClient`: `PATCH` support, `requestMultipart()` (POST/PUT/PATCH),
  and `requestRaw()` for binary downloads.

### Fixed

- `BlockingModule` imported `BlockStatusResponse` from a namespace that does
  not exist, making every method in the module a fatal class-not-found.

### Notes

- `GET /events/tail` (SSE) and `calls/media/ws` (WebSocket) are deliberately
  not covered — the HTTP plumbing has no streaming support yet.
- Business catalog/collection/order and newsletter management responses are
  raw server debug strings; the DTOs hold them as `string` plus cursors.

## 1.0.3 - 2026-07-22

- Fix `SendResponse` DTO mapping for message send endpoints.

## 1.0.2 - 2026-07-22

- Further media module fixes.

## 1.0.1 - 2026-07-22

- Fix media module and upload media response mapping.

## 1.0.0 - 2026-07-22

- Initial release of `waxum-php-client` for Waxum WhatsApp REST API gateway.
