namespace testS\models\blocks\image;
use testS\application\components\Db;

use testS\models\blocks\image\_abstract\AbstractUpdateModel;
class ImageInstanceModel extends AbstractUpdateModel
     * @param int $groupId Group ID
        $this->getDb()->addWhere('t.imageGroupId = :imageGroupId');
        $this->getDb()->addParameter('imageGroupId', $groupId);
        $this->getDb()->setOrder('t.isCover DESC, t.sort');
     * @param int $groupId Group ID
        $this->getDb()->addWhere('t.imageGroupId = :imageGroupId');
        $this->getDb()->addParameter('imageGroupId', $groupId);
     * @param int $imageId Image ID
            'imageGroups',
            'imageGroups',
            'imageGroupId'
        $this->getDb()->addWhere(
            'imageGroups.imageId = :imageId'
        );
        $this->getDb()->addParameter('imageId', $imageId);
}