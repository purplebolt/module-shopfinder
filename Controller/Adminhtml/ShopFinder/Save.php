<?php
/**
 * Copyright © 2023 All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Chalhoub\ShopFinder\Controller\Adminhtml\ShopFinder;

use Magento\Framework\Exception\LocalizedException;
use Chalhoub\ShopFinder\Api\ShopFinderRepositoryInterface;
use Magento\Framework\App\ResourceConnection;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    protected ShopFinderRepositoryInterface $_shopFinderRepository;

    protected ResourceConnection $_connection;

    /**
     * @param ShopFinderRepositoryInterface $shopFinderRepository
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        ShopFinderRepositoryInterface $shopFinderRepository,
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        ResourceConnection $resourceConnection
    ) {
        $this->_shopFinderRepository = $shopFinderRepository;
        $this->dataPersistor = $dataPersistor;
        $this->_connection = $resourceConnection;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('shop_id');

            $model = $this->_objectManager->create(\Chalhoub\ShopFinder\Model\ShopFinder::class)->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addErrorMessage(__('This Shop no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            if (isset($data['shopImage'][0])) {
                $model->setData('shopImage', $data['shopImage'][0]['name']);
            } else {
                if ($model->getId()) {
                    $this->_connection->getConnection()->update(
                        $this->_connection->getTableName('chalhoub_shopfinder'),
                        ['shopImage'=>null],
                        ['shop_id = ?' => (int) $model->getId()]
                    );
                }
                //$model->setData('shop_image', null);
                //$model->setShopImage(null);
            }

            try {
                $this->_shopFinderRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the Shop.'));
                $this->dataPersistor->clear('chalhoub_shopfinder');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['shop_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Shop.'));
            }

            $this->dataPersistor->set('chalhoub_shopfinder', $data);
            return $resultRedirect->setPath('*/*/edit', ['shop_id' => $this->getRequest()->getParam('shop_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

