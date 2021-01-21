<?php

declare(strict_types=1);

namespace Academy\Student\EntryPoint\Http\Controller;

use Academy\Shared\Infrastructure\Symfony\Exception\SymfonyException;
use Academy\Student\Application\EvaluateActivity\EvaluateActivityCommand;
use Academy\Shared\Infrastructure\Symfony\ApiResponseResource;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;

final class EvaluateActivityController
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * EvaluateActivity the answer of activity from itinerary done by student.
     *
     *
     * @Route("/api/students/{student_uuid}/itinerary/{itinerary_uuid}/activity/evaluate", methods={"POST"})
     * @OA\Response(
     *     response=201,
     *     description="Activity evaluated successfully",
     *        @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                property="data",
     *                type="object",
     *                ),
     *                @OA\Property(
     *                  property="meta",
     *                  type="object",
     *                     @OA\Property(
     *                          property="success",
     *                          type="boolean",
     *                          example="true"
     *                     ),
     *                     @OA\Property(
     *                          property="message",
     *                          type="string",
     *                          example="Evaluation of activity name: A3 for student uuid: 70f066f6-1cb7-4c45-97e2-287f0258ba02 done successfully"
     *                     ),
     *                      @OA\Property(
     *                          property="errors",
     *                          type="array",
     *                          @OA\Items(),
     *                     ),
     *              ),
     *        ),
     * )
     * @OA\Response(
     *     response=404,
     *     description="The itinerary, student or activity has not been found on database",
     *        @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                  property="data",
     *                  type="object",
     *                ),
     *                @OA\Property(
     *                  property="meta",
     *                  type="object",
     *                     @OA\Property(
     *                          property="success",
     *                          type="boolean",
     *                          example="false"
     *                     ),
     *                     @OA\Property(
     *                          property="message",
     *                          type="string",
     *                          example="The activity has not been found"
     *                     ),
     *                      @OA\Property(
     *                          property="errors",
     *                          type="array",
     *                          @OA\Items(
     *                              @OA\Property(
     *                                 property="uuid",
     *                                 type="string",
     *                                 example="The activity name A31 doesn't exist"
     *                              ),
     *                          ),
     *                     ),
     *              ),
     *        ),
     * )
     * @OA\Response(
     *     response=500,
     *     description="Validation of request body failed (attributes answer or inverted_time)",
     *        @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                  property="data",
     *                  type="object",
     *                ),
     *                @OA\Property(
     *                  property="meta",
     *                  type="object",
     *                     @OA\Property(
     *                          property="success",
     *                          type="boolean",
     *                          example="false"
     *                     ),
     *                     @OA\Property(
     *                          property="message",
     *                          type="string",
     *                          example="Validation error evaluate constraint"
     *                     ),
     *                      @OA\Property(
     *                          property="errors",
     *                          type="array",
     *                          @OA\Items(
     *                              @OA\Property(
     *                                 property="inverted_time",
     *                                 type="string",
     *                                 example="This value is too short. It should have 1 character or more."
     *                              ),
     *                          ),
     *                     ),
     *              ),
     *        ),
     * )
     *
     * @OA\Parameter(
     *     name="student_uuid",
     *     in="path",
     *     description="The uuid of student to evaluate",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="itinerary_uuid",
     *     in="path",
     *     description="The uuid of itinerary that is linked to the activity to evaluate",
     *     @OA\Schema(type="string")
     * )
     * @OA\Parameter(
     *     name="activity_name",
     *     in="query",
     *     required=true,
     *     description="The activity name to evaluate",
     *     @OA\Schema(type="string")
     * )
     *
     * @OA\RequestBody(
     *    required=true,
     *    description="Answer and time (in seconds) from activity done by student",
     *    @OA\JsonContent(
     *       required={"answer","inverted_time"},
     *       @OA\Property(property="answer", type="string", format="answer", example="1_0_2"),
     *       @OA\Property(property="inverted_time", type="integer", format="time", example=90),
     *    ),
     * )
     *
     * @OA\Tag(name="students")
     *
     * @param Request $request
     * @return Response
     * @throws \JsonException|SymfonyException
     */
    public function __invoke(Request $request): Response
    {
        $requestToArray = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $this->validateRequest($requestToArray);

        /** @var HandledStamp $envelope */
        $envelope = $this->commandBus->dispatch(new EvaluateActivityCommand(
            $request->get('student_uuid'),
            $request->get('itinerary_uuid'),
            $request->get('activity_name'),
            $requestToArray['answer'],
            $requestToArray['inverted_time']
        ))->last(HandledStamp::class);

        return (new ApiResponseResource(
            Response::HTTP_CREATED,
            [],
            [],
            $envelope->getResult(),
            true)
        )->getResponse();
    }

    /**
     * @param array $input
     * @throws SymfonyException
     */
    private function validateRequest(array $input): void
    {
        $constraint = new Assert\Collection(
            [
                'answer'   => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 1, 'max' => 20]),
                    new Assert\Type('string')
                ],
                'inverted_time'       => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 1, 'max' => 10]),
                    new Assert\Type('integer')
                ]
            ]
        );

        $validationErrors = Validation::createValidator()->validate($input, $constraint);

        if ($validationErrors->count() > 0) {
            $errors = [];
            foreach ($validationErrors as $error) {
                $errors[$error->getPropertyPath()][] = $error->getMessage();
            }
            throw new SymfonyException(
                'Validation error evaluate constraint',
                $errors
            );
        }

    }
}