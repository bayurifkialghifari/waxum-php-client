<?php

namespace Bayurifkialghifari\WaxumApi\DTOs\Webhook;

enum WebhookEventType: string
{
    case ALL = 'all';
    case MESSAGE = 'message';
    case RECEIPT = 'receipt';
    case PRESENCE = 'presence';
    case CHAT_PRESENCE = 'chat_presence';
    case GROUP_UPDATE = 'group_update';
    case JOINED_GROUP = 'joined_group';
    case QR_CODE = 'qr_code';
    case PAIR_CODE = 'pair_code';
    case CONNECTED = 'connected';
    case DISCONNECTED = 'disconnected';
    case LOGGED_OUT = 'logged_out';
    case PICTURE_UPDATE = 'picture_update';
    case USER_ABOUT_UPDATE = 'user_about_update';
    case PUSH_NAME_UPDATE = 'push_name_update';
    case CONTACT_UPDATE = 'contact_update';
    case DEVICE_LIST_UPDATE = 'device_list_update';
    case PIN_UPDATE = 'pin_update';
    case MUTE_UPDATE = 'mute_update';
    case ARCHIVE_UPDATE = 'archive_update';
    case MARK_CHAT_AS_READ = 'mark_chat_as_read';
    case UNDECRYPTABLE_MESSAGE = 'undecryptable_message';
    case CLIENT_OUTDATED = 'client_outdated';
    case OFFLINE_SYNC_PREVIEW = 'offline_sync_preview';
    case OFFLINE_SYNC_COMPLETED = 'offline_sync_completed';
    case SCHEDULED_SENT = 'scheduled_sent';
    case SCHEDULED_FAILED = 'scheduled_failed';
    case BLAST_PROGRESS = 'blast_progress';
    case BLAST_COMPLETED = 'blast_completed';
    case ACCOUNT_LOCKED = 'account_locked';
    case CALL_LOG_SYNC = 'call_log_sync';
    case STREAM_ERROR = 'stream_error';
    case ENC_DECRYPT_FAILED = 'enc_decrypt_failed';

    /**
     * @return string[]
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
