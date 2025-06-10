<?php
/**
 * This file is a placeholder. The PayPal webhook handling logic has been moved to SiteController::actionWebhook().
 * This file exists only to maintain backward compatibility with any existing code that might reference it.
 */

// Redirect to home page if accessed directly
use yii\helpers\Url;
return $this->redirect(Url::home());
?>
