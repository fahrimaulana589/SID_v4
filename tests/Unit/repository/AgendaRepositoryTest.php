<?php

namespace Tests\Unit\repository;

use Tests\TestCase;
use App\Models\Agenda;
use App\Repository\AgendaRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RepositoryTest extends TestCase
{

    use RefreshDatabase;

    public function test_getAll()
    {

        Agenda::factory(4)->create();
        $repo = new AgendaRepository;

        $agendas = $repo->getAll();

        $this->assertEquals(4,count($agendas));

    }

    public function test_getBy()
    {

        Agenda::factory(8)->create();
        $repo = new AgendaRepository;

        $agendas = $repo->getBy(2);

        $this->assertDatabaseHas('agendas',$agendas);

    }

    public function test_store()
    {

        $repo = new AgendaRepository;

        $data = [
            'title' => "cek",
            'description' => "cek cok"
        ];

        $agendas = $repo->store($data);

        $this->assertDatabaseHas('agendas',$data);

    }

    public function test_update()
    {
        Agenda::factory(8)->create();
        $repo = new AgendaRepository;

        $data = [
            'title' => "cek",
            'description' => "cek cok"
        ];

        $agendas = $repo->update($data,2);

        $this->assertDatabaseHas('agendas',$data);

    }

    public function test_destroy()
    {
        Agenda::factory(8)->create();
        $repo = new AgendaRepository;

        $agenda = $repo->getBy(2);

        $repo->destroy(2);

        $this->assertDatabaseMissing('agendas',$agenda);

    }


}
