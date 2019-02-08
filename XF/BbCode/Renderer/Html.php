<?php

namespace Truonglv\MentionerRich\XF\BbCode\Renderer;

use XF\Entity\User;

class Html extends XFCP_Html
{
    public function renderTagUser(array $children, $option, array $tag, array $options)
    {
        $content = $this->renderSubTree($children, $options);
        if ($content === '') {
            return parent::renderTagUser($children, $option, $tag, $options);
        }

        $userId = intval($option);
        if ($userId <= 0) {
            return parent::renderTagUser($children, $option, $tag, $options);
        }

        /** @var User|null $user */
        $user = \XF::em()->find('XF:User', $userId);
        if (!$user) {
            return parent::renderTagUser($children, $option, $tag, $options);
        }

        $user->username = $content;
        $user->setReadOnly(true);

        $templater = \XF::app()->templater();
        return $templater->fn('username_link', [$user, true]);
    }
}
