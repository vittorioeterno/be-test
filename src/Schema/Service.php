<?php

namespace App\Schema;


abstract class Service {





    ///////////////////////////////////////////
    /// OBJECT FUNCTIONS

    /**
     * Finalize and save the creation of the entity.
     * Returns NULL if some error occurs otherwise it returns the persisted object.
     *
     * @param $entity
     * @param bool $update
     * @return mixed
     * @throws \Exception
     */
    public function save($entity, bool $update = false) {

        try {

            try {
                $this->repository->save($entity, $update);
                return $entity;
            }catch (\Exception $e) {
                throw $e;
            }

        } catch (\Exception $e) {
            throw $e;
        }

    }

    /**
     * Delete a given entity.
     *
     * @param $entity
     * @return bool
     * @throws \Exception
     */
    public function remove($entity) {
        try {

            $exception = $this->repository->remove($entity);
            if (is_array($exception)) {
                throw new \Exception("The entity was not removed");
            }

        } catch (\Exception $e) {
            throw $e;
        }

    }

}
