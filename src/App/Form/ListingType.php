<?php

namespace App\Form;


use App\Entity\Listing;
use Parser\Parser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Context\ExecutionContext;

class ListingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('listing', TextareaType::class, [
                "label" => false,
                "attr" => [
                    "style" => "height: 180px"
                ],
                "constraints" => [
                    new NotNull(),
                    new NotBlank(),
                    new Length(["min" => 0, "max" => 1000]),
                    new Callback([$this, 'validateParser']),
                ]
            ])
        ;
    }

    public function validateParser($string, ExecutionContext $context)
    {
        try {
            Parser::fromString($string);
        } catch (\Exception $e) {
            $context
                ->buildViolation("Błąd w programie: " . $e->getMessage())
                ->addViolation();
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => false,
            'data_class' => Listing::class,
        ]);
    }
}