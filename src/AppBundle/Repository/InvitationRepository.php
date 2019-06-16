<?php

namespace AppBundle\Repository;

/**
 * InvitationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InvitationRepository extends \Doctrine\ORM\EntityRepository
{
	public function test_all(){
		$conn = $this->getEntityManager()
            ->getConnection();
        $sql = 'SELECT * FROM invitation';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        var_dump($stmt->fetchAll());die;
	}

	public function senderList($senderId){
		$conn = $this->getEntityManager()
            ->getConnection();
        $sql = '
            SELECT invitation.id, invited.name, invitation.status
            FROM invitation
            JOIN user invited ON invited.id = invitation.invitedid
            WHERE invitation.senderid = :senderid
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('senderid' => $senderId));
        //var_dump($stmt->fetchAll());

        return $stmt->fetchAll();
	}

	public function invitedList($invitedId){
		$conn = $this->getEntityManager()
            ->getConnection();
        $sql = '
            SELECT invitation.id, sender.name, invitation.status
            FROM invitation
            JOIN user sender ON sender.id = invitation.senderid
            WHERE invitation.invitedid = :invitedid and (invitation.status != 2 and invitation.status != 3)
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(array('invitedid' => $invitedId));
        //var_dump($stmt->fetchAll());

        return $stmt->fetchAll();
	}
}
