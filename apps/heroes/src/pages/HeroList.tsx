import HeroAttribute from "@src/components/HeroAttribute";
import { useHeroStore } from "@src/store/heroStore";
import {
  HeroAttributes,
  HeroClass,
  HeroModel,
  HERO_CLASSES,
  HERO_CLASS_COLORS,
} from "@src/types/heroes.type";
import { Button, notification, Popconfirm, Table } from "antd";
import type { ColumnsType } from "antd/es/table";
import React, { CSSProperties } from "react";
import { Link, useNavigate } from "react-router-dom";

function HeroList() {
  const openNotification = () => {
    notification.open({
      message: "Success",
      description: "Hero deleted!",
    });
  };

  const navigate = useNavigate();

  const heroes = useHeroStore((s) => s.heroes);

  const deleteHero = useHeroStore((s) => s.heroDelete);

  const onHeroDelete = (id: string) => {
    deleteHero(id);
    openNotification();
  };

  const columns: ColumnsType<HeroModel> = [
    {
      title: "ID",
      dataIndex: "id",
      key: "id",
      render: (value: string) => <span>{value}</span>,
    },
    {
      title: "Name",
      dataIndex: "name",
      key: "name",
      render: (value: string) => <span>{value}</span>,
      defaultSortOrder: "descend",
      sorter: (a, b) => a.name.localeCompare(b.name),
    },
    {
      title: "Class",
      dataIndex: "class",
      key: "class",
      render: (value: string) => <span>{value}</span>,
      filters: HERO_CLASSES.map((hero) => {
        return { text: hero, value: hero };
      }),
      onFilter: (value: string | number | boolean, record) =>
        record.class === value,
      filterMode: "tree",
    },
    {
      title: "Level",
      dataIndex: "level",
      key: "level",
      render: (value: number) => <span className="level-badge">{value}</span>,
    },
    {
      title: "Attributes",
      dataIndex: "attributes",
      key: "attributes",
      render: (attributes: HeroAttributes) => (
        <HeroAttribute attributes={attributes} />
      ),
    },
    {
      title: "Action",
      key: "action",
      render: (_, record) => (
        <Popconfirm
          title="Delete the hero"
          description="Are you sure to delete this hero?"
          okText="Yes"
          cancelText="No"
          okButtonProps={{ type: "primary" }}
          okType="danger"
          onConfirm={(e) => {
            e?.stopPropagation();
            onHeroDelete(record.id);
          }}
        >
          <Button
            type="primary"
            danger
            onClick={(event) => {
              event.stopPropagation();
            }}
          >
            Delete
          </Button>
        </Popconfirm>
      ),
    },
  ];

  const getRowStyle = (record: HeroModel): CSSProperties => {
    let heroClass: HeroClass = record.class;

    return {
      background: HERO_CLASS_COLORS[heroClass].color ?? "none",
      cursor: "pointer",
    };
  };

  const rowSelection = {
    onChange: (selectedRowKeys: React.Key[], selectedRows: HeroModel[]) => {
      // TODO: implement onchange event
    },
  };

  return (
    <div>
      <header className="yayhero-herolist-title">
        <h4>Heroes</h4>
        <Link to="/heroes/add">
          <Button type="primary">Add Heroes</Button>
        </Link>
      </header>

      <Table
        rowKey={(record) => record.id}
        columns={columns}
        dataSource={heroes}
        onRow={(record) => {
          return {
            onClick: () => {
              navigate(`/heroes/edit/${record.id}`);
            },
          };
        }}
        rowSelection={{
          type: "checkbox",
          ...rowSelection,
        }}
      />
    </div>
  );
}

export default HeroList;
