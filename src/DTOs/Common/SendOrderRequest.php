<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Common;

class SendOrderRequest
{
    public function __construct(
        public readonly ?int $itemCount,
        public readonly ?string $message,
        public readonly string $orderId,
        public readonly ?string $orderTitle,
        public readonly ?string $replyTo,
        public readonly ?string $sellerJid,
        public readonly ?string $sendAt,
        public readonly ?string $status,
        public readonly string $to,
        public readonly ?string $token = null,
        public readonly ?int $totalAmount1000 = null,
        public readonly ?string $totalCurrencyCode = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            itemCount: isset($data['item_count']) ? (int) $data['item_count'] : null,
            message: isset($data['message']) ? (string) $data['message'] : null,
            orderId: isset($data['order_id']) ? (string) $data['order_id'] : null,
            orderTitle: isset($data['order_title']) ? (string) $data['order_title'] : null,
            replyTo: isset($data['reply_to']) ? (string) $data['reply_to'] : null,
            sellerJid: isset($data['seller_jid']) ? (string) $data['seller_jid'] : null,
            sendAt: isset($data['send_at']) ? (string) $data['send_at'] : null,
            status: isset($data['status']) ? (string) $data['status'] : null,
            to: isset($data['to']) ? (string) $data['to'] : null,
            token: isset($data['token']) ? (string) $data['token'] : null,
            totalAmount1000: isset($data['total_amount_1000']) ? (int) $data['total_amount_1000'] : null,
            totalCurrencyCode: isset($data['total_currency_code']) ? (string) $data['total_currency_code'] : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'item_count' => $this->itemCount,
            'message' => $this->message,
            'order_id' => $this->orderId,
            'order_title' => $this->orderTitle,
            'reply_to' => $this->replyTo,
            'seller_jid' => $this->sellerJid,
            'send_at' => $this->sendAt,
            'status' => $this->status,
            'to' => $this->to,
            'token' => $this->token,
            'total_amount_1000' => $this->totalAmount1000,
            'total_currency_code' => $this->totalCurrencyCode,
        ], fn ($val) => $val !== null);
    }
}
