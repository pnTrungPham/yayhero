import HeroAttribute from "@src/components/HeroAttribute";
import { useHeroStore } from "@src/store/heroStore";
import {
  HeroAttributes,
  HeroModel,
  HERO_CLASSES,
} from "@src/types/heroes.type";
import { getErrorMessage } from "@src/utils/common";
import { notifySuccess } from "@src/utils/notification";
import { Button, Popconfirm, Table } from "antd";
import type { ColumnsType } from "antd/es/table";
import React, { CSSProperties } from "react";
import { Link, useNavigate } from "react-router-dom";

function HeroList() {
  const navigate = useNavigate();

  const heroes = useHeroStore((s) => s.list.heroes);

  const isTableLoading = useHeroStore((store) => store.list.isLoading);

  const deleteHero = useHeroStore((store) => store.heroDelete);

  const beginEditHeroByModel = useHeroStore(
    (store) => store.heroBeginEditByModel
  );

  const onHeroDelete = async (id: number) => {
    try {
      await deleteHero(id);
      notifySuccess({
        message: "Success",
        description: "Hero deleted!",
      });
    } catch (e) {
      const msg = await getErrorMessage(e);

      notifySuccess({
        message: "Error",
        description: msg,
      });
    }
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
    return {
      cursor: "pointer",
    };
  };

  const rowSelection = {
    onChange: (selectedRowKeys: React.Key[], selectedRows: HeroModel[]) => {
      // TODO: implement onchange event
    },
  };

  const handleOnRowClick = (record: HeroModel) => {
    beginEditHeroByModel(record);
    navigate(`/heroes/edit/${record.id}`);
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
        loading={isTableLoading}
        rowKey={(record) => record.id}
        columns={columns}
        dataSource={heroes}
        onRow={(record) => {
          return {
            onClick: () => handleOnRowClick(record),
            style: getRowStyle(record),
          };
        }}
        rowSelection={{
          type: "checkbox",
          ...rowSelection,
        }}
        pagination={{
          defaultPageSize: 10,
          showSizeChanger: true,
          pageSizeOptions: ["10", "20", "30"],
        }}
      />
    </div>
  );
}

export default HeroList;
